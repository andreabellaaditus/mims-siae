<?php

namespace App\Services;

use App\Http\Helpers\Functions;
use App\Models\SiaeOrderItem;
use App\Models\SiaeOrder;
use App\Models\ReductionField;
use App\Models\SiaeOrderItemReduction;
use App\Services\OrderService;
use App\Services\ProductService;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;
use Illuminate\Support\Facades\DB;

class OrderItemService
{

    public function create($product, $order){

        $additional_code = $product->has_additional_code ? self::getAdditionalCode() : null;
        $orderItemStatusService = new OrderItemStatusService;
        $purchasedStatusId = $orderItemStatusService->getPurchasedStatusId();
        $productService = new ProductService($product);
        $orderItemData = [
            'product_id' => $product->id,
            'siae_order_id' => $order->id,
            'validity' => $productService->getValidity()->format("Y-m-d H:i:s"),
            'is_cumulative' => $product->is_cumulative,
            'qty' => $product->qty,
            'date_service' => $product->date_service,
            'hour_service' => $product->hour_service,
            'order_item_status_id' => $purchasedStatusId,
            'printable_qr_code' => self::generatePrintableQrcode($product->qty, $product),
            'price' => $product->price_sale * $product->qty,
            'additional_code' => $additional_code,
        ];

        return SiaeOrderItem::create($orderItemData);
    }

    public function insertRelated($product, $order){

        $additional_code = $product->has_additional_code ? self::getAdditionalCode() : null;
        $orderItemStatusService = new OrderItemStatusService;
        $purchasedStatusId = $orderItemStatusService->getPurchasedStatusId();
        $productService = new ProductService($product);

        $orderItemData = [
            'product_id' => $product->id,
            'siae_order_id' => $order->id,
            'validity' => $productService->getValidity()->format("Y-m-d H:i:s"),
            'is_cumulative' => $product->is_cumulative,
            'qty' => $product->qty,
            'date_service' => $product->date_service,
            'hour_service' => $product->hour_service,
            'order_item_status_id' => $purchasedStatusId,
            'printable_qr_code' => 0,
            'price' => $product->price_sale,
            'additional_code' => $additional_code,
        ];
        return SiaeOrderItem::create($orderItemData);
    }

    public static function generatePrintableQrcode($qty, $product){
        $orderService = new OrderService;

        if($product->service->product_category->slug == 'tickets' || $product->service->product_category->slug == 'site-events'){
            $matrices = $orderService->getMatrices($product, $qty)->toArray();
            $matrix_id = $matrices[0]['id'];
        }else{
            $matrix_id = 0;
        }
        return Functions::generateQrCodeHash($product->id, $matrix_id);
    }

    public function updateByOrderId($id, $data){
        SiaeOrderItem::where('siae_order_id', $id)->update($data);
    }

    public function getAdditionalCode(){
        return strtoupper(substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 5));
    }

    public function getListExport($cashier_id, $created_from = null, $created_until = null){

        $items_query = SiaeOrderItem::select('siae_order_items.*')->with([
            'payment.payment_type',
            'order',
            'order.user',
            'order.cashier',
            'product',
            'scans'
        ])
        ->join('siae_orders',  'siae_orders.id', '=', 'siae_order_items.siae_order_id')
        ->where('siae_orders.cashier_id', $cashier_id)
        ->whereDate('siae_orders.created_at', '=', date('Y-m-d'))
        ->when($created_from, function ($query, $created_from) {
            return $query->where('siae_orders.created_at', '>=', date('Y-m-d')." ".$created_from);
        })
        ->when($created_until, function ($query, $created_until) {
            return $query->where('siae_orders.created_at', '<=', date('Y-m-d')." ".$created_until);
        })
        ->orderBy('siae_order_items.id', 'desc');

            $ids_da_rimuovere = [];
            $items_query = $items_query->get();
            $items_query_check_related = $items_query;
            foreach ($items_query as $item) {
                if (count($item->product->related_products) > 0) {
                    $related_products = $item->product->related_products;
                    foreach ($related_products as $related_product) {
                        foreach($items_query_check_related AS $item_to_check){
                            if($item_to_check->product_id == $related_product->id && $item_to_check->order->id == $item->order->id){
                                $ids_da_rimuovere[] = $item_to_check->id;
                            }
                        }
                        $item->price+= $related_product->price_sale;
                    }
                }
            }
            $items_query = $items_query->reject(function ($item) use ($ids_da_rimuovere) {
                return in_array($item->id, $ids_da_rimuovere);
            });

            $product_totals = [];
            $payment_totals = [];

            foreach($items_query as $item){
                $product_id = $item->product_id;

                if(array_key_exists($product_id, $product_totals)){
                    $product_totals[$product_id]['total_price'] += $item->price;
                    $product_totals[$product_id]['tot_qty'] += $item->qty;
                } else {
                    $product_totals[$product_id] = [
                        'tot_qty' => +$item->qty,
                        'total_price' => $item->price,
                        'name' => $item->product->name
                    ];
                }

                $payment_type_id = $item->order->payment->payment_type->id;

                if(array_key_exists($payment_type_id, $payment_totals)){
                    $payment_totals[$payment_type_id]['total_price'] += $item->price;
                    $payment_totals[$payment_type_id]['tot_qty'] += $item->qty;
                } else {
                    $payment_totals[$payment_type_id] = [
                        'tot_qty' => +$item->qty,
                        'total_price' => $item->price,
                        'name' => $item->order->payment->payment_type->name
                    ];
                }
            }

            return [
                'items' => $items_query,
                'grouped_by_product' => $product_totals,
                'grouped_by_payment_type' => $payment_totals
            ];

    }

    public function getListBySite($cashier_id){

     $orders = SiaeOrderItem::select('siae_order_items.id')->join('siae_orders', 'siae_order_items.siae_order_id', '=', 'siae_orders.id')
        ->where('siae_orders.cashier_id', $cashier_id)
        ->whereDate('siae_orders.created_at', date('Y-m-d'))
        ->orderBy('siae_orders.id', 'desc')
        ->take(20)->get();
        $array_ids = array();
        foreach($orders as $order){
            $array_ids[] = $order->id;
        }

        $items_query = SiaeOrderItem::with([
            'payment.payment_type',
            'order',
            'order.user',
            'order.cashier',
            'product',
            'scans'
        ])->whereIn('id', $array_ids)
        ->orderBy('id', 'desc');
        return $items_query;
    }

    public function checkDateAndHour($product){
        if ($product->is_date && $product->date_service == null) {
            throw new \Exception(__('orders.no-date-filled'));
        }
        if ($product->is_hour && ($product->hour_service == null || $product->hour_service == "00:00:00")) {
            throw new \Exception(__('orders.no-hour-filled'));
        }
    }

}
