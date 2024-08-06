<?php

namespace App\Services;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;
use App\Models\SiaeOrder;
use App\Models\Order;
use App\Models\User;
use App\Models\SiaeScan;
use App\Models\SiaeOrderReprint;
use App\Services\MatrixService;
use App\Services\ProductService;
use App\Models\VirtualStoreMatrix;
use App\Models\Product;
use App\Models\SiaeOrderItemReduction;
use App\Models\SiaeProductHolder;
use App\Http\Helpers\Functions;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PDF;

class OrderService
{
    public function create($data){
        return SiaeOrder::create($data);
    }

    public function update($id, $data){

        return SiaeOrder::where('id', $id)->update($data);
    }

    public function updateAfterPayment($id, $payment_record){

        $dataUpdate = [
            'price' => $payment_record->total,
            'payment_id' => $payment_record->id,
            'completed_at' => date('Y-m-d H:i:s')
        ];
        return SiaeOrder::where('id', $id)->update($dataUpdate);
    }

    /*public function getProgressive(){
        return SiaeOrder::selectRaw('progressive as prog')->where('order_type_id', 3)->orderBy('progressive', 'desc')->first();
    }*/


    public function read($order_id){
        return SiaeOrder::findOrFail($order_id);
    }

    public function setCurrentUserSession($site_id, $value)
    {
        $currentUserSessionKey = $this->getCurrentUserSessionKey($site_id);
        Session::put($currentUserSessionKey, $value);
    }

    public function getCurrentUser($site, $userId = null)
    {
        $loggedUser = auth()->user();
        $currentUserId = $userId ?: $this->getCurrentUserSession($site);
        $currentUser = $currentUserId ? User::find($currentUserId) : $loggedUser;

        return $currentUser;
    }

    private function getCurrentUserSession($site_id)
    {
        $currentUserSessionKey = $this->getCurrentUserSessionKey($site_id);
        return Session::get($currentUserSessionKey);
    }

    private function getCurrentUserSessionKey($site_id)
    {
        return 'currentUserId_' . $site_id;
    }

    function layout_onsite_ticket($order_id)
    {
        //$message = $request->input('message');
        $size = "small";
        $order = SiaeOrder::with(['items', 'items.product', 'items.product.service.product_category', 'items.scans', 'items.product.service.site'])->find($order_id);
        if ($order->printed_at) {
            /*if ($message) {
                $order->notes = $message;
            }*/
            $user = auth()->user();

            SiaeOrderReprint::create([
                'siae_order_id' => $order->id,
                'user_id' => $user->id,
            ]);
        }

        $ticketLayoutTemplate = 'onsite.ticket-layout.ticket';

        $pdf = PDF::loadView($ticketLayoutTemplate, ["order" => $order, 'listeners' => ['scan']]);
        if ($size == "large") {
            $pdf->setPaper([0, 0, 433.701, 184.252], 'portrait');
        }
        if ($size == "small") {
            $pdf->setPaper([0, 0, 243.78, 153.071], 'portrait');
        }

        $date = Carbon::now();
        $order->printed_counter = $order->printed_counter + 1;
        $order->printed_at = $date->format('Y-m-d H:i:s');
        $order->save();
        return $pdf->stream();

    }



    static function purchaseGroupEnabled()
    {
        return env('ENABLE_PURCHASE_GROUP') == 'enabled' ? true : false;
    }


    public function orderCheckMatrix($order, $type)
    {
        $arrScans = [];
        $productToRedistribute = [];

        $order = SiaeOrder::with('items', 'items.product', 'items.product.service.product_category')->find($order->id);

        $defaultPurchaseGroup = null; //self::purchaseGroupEnabled() ? Matrix::getPurchaseGroupByChashierId($order->cashier_id) : null;

        DB::beginTransaction();
        try {

            foreach ($order->items as $item) {
                if ($item->product->service->product_category->slug == "tickets" || $item->product->service->product_category->slug == "site-events") {
                    $itemScans = self::getScanInfo($type, $item, $item->product, $defaultPurchaseGroup);
                    foreach ($itemScans as $scan) {
                        $arrScans[] = $scan;
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        DB::commit();
        SiaeScan::insert($arrScans);
    }


    static function getScanInfo($type, $item, $product, $defaultPurchaseGroup)
    {
        $scans = [];
        $itemQty = $item->qty ?: 1;

        $matrices = self::getMatrices($product, $itemQty, $defaultPurchaseGroup);
        if($item->product->service->product_category->slug == 'tickets' || $item->product->service->product_category->slug == 'site-events'){

            if (empty($matrices) || count($matrices) < $itemQty) {
                throw new \Exception('Il museo ' . $product->service->site->name . ' ha terminato i biglietti tipologia: ' . $product->name);
            } else {
                foreach ($matrices as $matrix) {
                    $matricesIds[] = $matrix->id;
                    $qr_code = Functions::generateQrCodeHash($product->id, $matrix->id);
                    $scans[] = Functions::collectScanMatrix($item, $qr_code, $matrix->id, $type);
                }
                VirtualStoreMatrix::whereIn('id', $matricesIds)->update(["status" => "Matrice Acquistata"]);
            }
        }else{
            $qr_code = Functions::generateQrCodeHash($product->id, 0);
            $scans[] = Functions::collectScanMatrix($item, $qr_code, 0, $type);
        }
        return $scans;
    }

    static function getMatrices($product, $itemQty, $defaultPurchaseGroup = null)
    {
        $matrixService = new MatrixService;
        $matrices = $matrixService->getMatrices($product, $itemQty, $defaultPurchaseGroup);
        return $matrices;
    }

    public function insertHolders($array_names, $order_item_id, $product_id){
        $product = Product::find($product_id);
        if (isset($array_names[$product_id])) {
            foreach ($array_names[$product_id] as $fields_array) {
                if ($fields_array['first_name'] != '' && $fields_array['last_name'] != '') {
                    $productService = new ProductService($product);
                    $dataProductHolder = [
                        'siae_order_item_id' => $order_item_id,
                        'product_id' => $product_id,
                        'first_name' => $fields_array['first_name'],
                        'last_name' => $fields_array['last_name'],
                        'expired_at' => $productService->getValidity()->format("Y-m-d H:i:s"),
                    ];
                    ProductHolder::create($dataProductHolder);
                } else {
                    throw new \Exception(__('orders.no-name-data-filled'));
                }
            }
        } elseif ($product->is_name == 1) {
            throw new \Exception(__('orders.no-name-data-filled'));
        }

    }

    public function insertRequiredFields($array_red_fields, $order_item_id, $product_id){

        $product = Product::find($product_id);
        if (isset($array_red_fields[$product_id])) {
            foreach ($array_red_fields[$product_id] as $fields_array) {
                foreach ($fields_array as $reduction_field_id => $field) {
                    if ($field['value'] != '') {
                        $dataRedFields = [
                            'siae_order_item_id' => $order_item_id,
                            'reduction_id' => $field['reduction_id'],
                            'reduction_field_id' => $reduction_field_id,
                            'value' => $field['value']
                        ];

                        SiaeOrderItemReduction::create($dataRedFields);
                    } else {
                        throw new \Exception(__('orders.no-reduction-fields-filled'));
                    }
                }
            }
        } elseif ($product->check_document == 1) {
            throw new \Exception(__('orders.no-reduction-fields-filled'));
        }
    }


    public static function getOrderNumber($prefix, $progressive)
    {
        $progressive = sprintf("%'.08d", $progressive);

        return $prefix . '-' . date('Y') . '-' . $progressive;
    }

    /*public static function getProgressive($prefix)
    {
        $lastSiaeOrder = SiaeOrder::select('progressive')
            ->where("order_number", 'like', '%' . $prefix . '%')
            ->whereYear('created_at', date('Y'))
            ->orderBy('progressive', 'desc')
            ->first();

        $lastOrder = Order::select('progressive')
            ->where("order_number", 'like', '%' . $prefix . '%')
            ->whereYear('created_at', date('Y'))
            ->orderBy('progressive', 'desc')
            ->first();

        $lastProgressive = max(
            $lastSiaeOrder ? $lastSiaeOrder->progressive : 0,
            $lastOrder ? $lastOrder->progressive : 0
        );
        return $lastProgressive + 1;

    }*/

    public static function getProgressive($prefix)
    {
        $year = date('Y');
        $query = "
            SELECT MAX(progressive) as max_progressive
            FROM (
                SELECT progressive
                FROM siae_orders
                WHERE order_number LIKE ? AND YEAR(created_at) = ?
                UNION ALL
                SELECT progressive
                FROM orders
                WHERE order_number LIKE ? AND YEAR(created_at) = ?
            ) as combined
        ";

        $maxProgressive = DB::select($query, ["%$prefix%", $year, "%$prefix%", $year]);

        $lastProgressive = $maxProgressive[0]->max_progressive ?? 0;

        return $lastProgressive + 1;
    }



    static function bolloIsNeeded($totalOrder)
    {
        return $totalOrder > 77.74 ? true : false;
    }


    public function order_check_matrix_online($orderId)
    {
        $this->order_check_matrix('online', $orderId);
    }

    private function
    order_check_matrix($type, $orderId)
    {
        $arr_scans = [];
        $productToRedistribute = [];

        $order = SiaeOrder::with('items','items.product','items.product.service.product_category')->find($orderId);

        if ($type == 'travel-agency') {
            Matrix::addAgencyOrderQueue($order->id);
        } elseif ($type == 'onsite') {

            $defaultPurchaseGroup = Matrix::getPurchaseGroupByChashierId($order->cashier_id);

            DB::beginTransaction();
            try {
                foreach ($order->items as $item) {
                    if ($item->product->service->product_category->name == "tickets") {
                        $itemScans = self::getScanInfo($type, $item, $item->product, $defaultPurchaseGroup);
                        foreach ($itemScans as $scan){
                            $arr_scans[] = $scan;
                        }
                    }
                }

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

            DB::commit();
            Scan::insert($arr_scans);

        }


    }



}
