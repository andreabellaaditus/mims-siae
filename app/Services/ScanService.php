<?php

namespace App\Services;
use Filament\Notifications\Notification;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;
use App\Models\SiaeScan;
use App\Models\Slot;
use App\Models\SiaeOrderItem;
use App\Models\CumulativeScan;
use App\Models\VirtualStoreMatrix;
use App\Models\ProductCumulative;
use App\Services\ProductService;
use App\Services\CashierService;
use App\Services\SiaeService;
use Illuminate\Support\Facades\DB;

class ScanService
{

    public function scan($qr_code, $cumulative_ticket, $siae_order_item_id, $product, $scan){

        $siaeService = new SiaeService();

            $cashierService = new CashierService;
            $cashier_id = $cashierService->getCurrentCashierSession(session('site_id'));

            if(!$cumulative_ticket){
                $field_name = 'qr_code';
                $field_value = $qr_code;
            }else{
                $field_name = 'siae_order_item_id';
                $field_value = $siae_order_item_id;
            }
            if ($product->is_cumulative) {
                $this->writeCumulativeScan(session('site_id'), $product->id, $qr_code);
            }
            $productService = new ProductService($product);
            if(SiaeScan::where($field_name, $field_value)->update(
                ['is_scanned' => DB::raw('is_scanned + 1'),
                'date_scanned' => date('Y-m-d H:i:s'),
                'date_expiration' => $productService->getExpiration(),
                'operator_id' => $cashier_id])){
                    if($scan->is_scanned > 0){
                        return VirtualStoreMatrix::find($scan->virtual_store_matrix_id)->update([
                            'status' => 'Matrice Utilizzata'
                        ]);
                    }else{
                        return true;
                    }
            }

        if($product->service->product_category->slug == 'site-events'){
            return $siaeService->ingressoEffettuato($product->code, $qr_code);
        }

    }

    public function getScanInfo($qr_code){
        $scan = SiaeScan::where('qr_code', $qr_code)->first();
        if(!$scan){
            $scan = SiaeOrderItem::where('printable_qr_code', $qr_code)->first();
            $scan->date_expiration = $scan->validity;
            return $scan;
        }else{
            $scan->order_item->date_expiration = $scan->date_expiration;
            $scan->order_item->is_scanned = $scan->is_scanned;
            $scan->order_item->virtual_store_matrix_id = $scan->virtual_store_matrix_id;
            return $scan->order_item;
        }

    }

    public function checkScans($scan, $site_id, $qr_code){
        $res['error'] = 0;
        $res['message'] = '';
        if($scan->product->is_cumulative){
            $check_sites = ProductCumulative::where(['product_id' => $scan->product->id, 'site_id' => $site_id])->count();
            if(!$check_sites){
                return false;
            }else{
                $cumulativeScans = CumulativeScan::where('qr_code', '=', $qr_code)->count();

                if ($cumulativeScans) {
                    $res = $this->checkValidityDate($scan);
                    if($res['error'] == 0){
                        $res = $this->checkValidityEntrance($scan, $site_id);
                    }
                }
            }
        }else{
            if($scan->product->max_scans <= $scan->is_scanned){
                $res['error'] = 1;
                $res['message'] = __('orders.scan.max-scans');
            }
        }
        return $res;
    }


    private function _getNow()
    {
        return Carbon::now('Europe/Rome');
    }
    private function checkValidityDate($scan)
    {
        $res['error'] = 0;
        $res['message'] = '';
        $now = $this->_getNow();
        $productService = new ProductService($scan->product);
        $firstScan = CumulativeScan::where('qr_code', '=', $scan->qr_code)
            ->whereRaw('DATE(created_at) <= ?',
                $now->subDays($productService->getValidityDays())->format('Y-m-d H:i:s'))
            ->orderBy('created_at', 'asc')
            ->first();

        if ($firstScan) {

            $res['error'] = 1;
            $res['message'] = __('orders.scan.ticket-expired');
        }
        return $res;
    }

    private function checkValidityEntrance($scan, $sourceSiteId)
    {
        $res['error'] = 0;
        $res['message'] = '';

        $burnedSites = [];
        $cumulativeScans = CumulativeScan::where('qr_code', '=', $scan->qr_code)->orderBy('created_at', 'asc')->get();
        $cumulativeScan = CumulativeScan::where('site_id', '=', $sourceSiteId)
            ->where('qr_code', '=', $scan->qr_code)
            ->first();

        foreach ($scan->product->sites as $site) {
            $enabledSites[] = $site->id;
        }

        foreach ($cumulativeScans as $scan) {
            $cumulativeSite = ProductCumulative::where(['site_id' => $sourceSiteId, 'product_id' => $scan->product_id ])->first();
            if ($cumulativeScan &&
                $scan->site_id == $sourceSiteId &&
                $cumulativeScan->scans < $cumulativeSite->max_scans) {

            } else {
                $burnedSites[$scan->site_id] = $scan->site->name . " (" . $scan->created_at . ")";
                if (in_array($scan->site_id, $enabledSites)) {
                    if (($key = array_search($scan->site_id, $enabledSites)) !== false) {
                        unset($enabledSites[$key]);
                    }
                }
            }
        }

        if (!in_array($sourceSiteId, $enabledSites)) {
            $burnedSitesList = implode(', ', $burnedSites);

            $res['error'] = 1;
            $res['message'] = __('orders.scan.ticket-already-scanned')." :".$burnedSitesList;
        }
        return $res;
    }

    public function updateExpirationDate($qr_code, $newExpirationDate){
        return SiaeScan::where('qr_code', $qr_code)->update(['date_expiration' => $newExpirationDate]);
    }

    public function getHour($weekday_order, $field_name, $field_id){

        return Slot::where('slot_days', 'like', '%'.$weekday_order.'%')
        ->where($field_name, $field_id)->first();

    }


    private function writeCumulativeScan($sourceSiteId, $product_id, $qr_code)
    {

        $cumulativeScan = CumulativeScan::where('site_id', '=', $sourceSiteId)
            ->where('qr_code', '=', $qr_code)
            ->first();
        if (!$cumulativeScan) {
            $cumulativeScan = new CumulativeScan();
            $cumulativeScan->qr_code = $qr_code;
            $cumulativeScan->product_id = $product_id;
            $cumulativeScan->site_id = $sourceSiteId;
            $cumulativeScan->scans = 1;
            $cumulativeScan->save();
        } else {
            $cumulativeScan->increment('scans');
            $cumulativeScan->save();
        }

    }
}



