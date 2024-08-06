<?php

namespace App\Services;
use Carbon\Carbon;
use App\Models\VirtualStoreLot;
use App\Models\VirtualStoreStatus;
use App\Models\VirtualStoreOrder;
use App\Models\VirtualStoreMatrix;
use App\Models\Cashier;
use App\Models\Scopes\ActiveScope;

class MatrixService
{
    const MATRIX_PRIORITY_LOW = 'low';
    const MATRIX_PRIORITY_HIGH = 'high';
    const MATRIX_PRIORITY_DEFAULT = self::MATRIX_PRIORITY_LOW;

    const MATRIX_PURCHASE_GROUP_FOR_ONLINE_USER = 0;


    static function getPurchaseGroupByCashierId($cashierId = null)
    {
        $cashier = Cashier::find($cashierId);
        $purchaseGroup = self::MATRIX_PURCHASE_GROUP_FOR_ONLINE_USER;

        if (!$cashier) {
            $purchaseGroup = self::MATRIX_PURCHASE_GROUP_FOR_ONLINE_USER;
        } else {
            $index = 1;
            foreach ($cashier->site->cashiers as $cashierItem) {
                if ($cashierItem->online != 1) {
                    if ($cashierId == $cashierItem->id) {
                        $purchaseGroup = $index;
                        continue;
                    }
                    $index++;
                }
            }
        }
        return $purchaseGroup;
    }

    public function getMatrices($product, $itemQty, $defaultPurchaseGroup = null){

        $now = Carbon::now();
            if ($product->matrix_generation_type && $product->matrix_generation_type->value == 'on_request') {

                $prefix = $product->virtual_store_settings;
                $lot = VirtualStoreLot::where('product_id', $product->id)
                    ->orderBy('id','desc')
                    ->first();

                $user_id = 1;
                $company_id = 1;
                $qty = 999999999;
                $virtual_store_order_id = 1;

                $virtualStoreStatus = VirtualStoreStatus::where('name','downloaded')->first();

                if(!$lot){

                    $virtual_store_order = VirtualStoreOrder::where('product_id', $product->id)
                        ->orderBy('id','desc')->first();

                    if(!$virtual_store_order){
                        $virtual_store_order = new VirtualStoreOrder();
                        $virtual_store_order->product_id = $product->id;
                        $virtual_store_order->user_id = $user_id;
                        $virtual_store_order->qty = $qty;
                        $virtual_store_order->description = "Ordine generato automaticamente";
                        $virtual_store_order->status = "Ordine Evaso";
                        $virtual_store_order->save();
                        $virtual_store_order_id = $virtual_store_order->id;
                    }
                    else{
                        $virtual_store_order_id = $virtual_store_order->id;
                    }

                    $virtualStoreLot = new VirtualStoreLot;
                    $virtualStoreLot->product_id = $product->id;
                    $virtualStoreLot->name = $now->format('Ymd-His');
                    $virtualStoreLot->user_id = $user_id;
                    $virtualStoreLot->company_id = $company_id;
                    $virtualStoreLot->status_id = $virtualStoreStatus->id;
                    $virtualStoreLot->qty = $qty;
                    $virtualStoreLot->virtual_store_order_id = $virtual_store_order_id;
                    $virtualStoreLot->save();
                    $lotId = $virtualStoreLot->id;
                }
                else{
                    $lotId = $lot->id;
                }

                $progressiveMatrix = VirtualStoreMatrix::where('product_id', $product->id)
                    ->orderBy('progressive', 'desc')
                    ->lockForUpdate()
                    ->first();
                $progressive  = $progressiveMatrix ? $progressiveMatrix->progressive : 0;
                for($i = 0; $i < $itemQty;  $i++){
                    $progressive++;
                    $matrix = [
                        'product_id' => $product->id,
                        'lot_id' => $lotId,
                        'code' => $prefix->value,
                        'year' => date("y"),
                        'progressive' => str_pad($progressive*1,7   ,0,STR_PAD_LEFT),
                        'status' => 'Matrice Caricata',
                        'purchased_at' => $now->format('Y-m-d H:i:s')
                    ];

                    $matricesIds[] = VirtualStoreMatrix::create($matrix)->id;
                }
                $matrices = VirtualStoreMatrix::whereIn('id',$matricesIds);
            } else {

                $matrices = VirtualStoreMatrix::where('status', 'Matrice Scaricata')
                    ->where('product_id', $product->id)
                    ->orderBy('progressive', 'asc')
                    ->limit($itemQty);
                /*if (self::purchaseGroupEnabled()) {
                    $availability = self::checkAvailabilityMatricesForProductId($product->id, $defaultPurchaseGroup);
                    $purchaseGroup = $availability > 0 ? $defaultPurchaseGroup : Matrix::getPurchaseGroupWithHighestAvailability($product->id, Matrix::MATRIX_PURCHASE_GROUP_FOR_ONLINE_USER);
                    $matrices = $matrices->where('purchase_group', $purchaseGroup);
                    if ($purchaseGroup != $defaultPurchaseGroup) {
                        $productToRedistribute[] = $product->id;
                    }
                }*/

            }
        $matrices_res = (isset($matrices)) ? $matrices->lockForUpdate()->get() : 0;
        //$matrices = $matrices->lockForUpdate()->get();

        return $matrices_res;

    }

}
