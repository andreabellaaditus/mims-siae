<?php

namespace App\Services;
use App\Models\Cart;
use App\Models\ReductionField;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;

class StockService
{

    public function getStockInfo($siteId, $cashierId)
    {
        $stockList = [];
        $_stockProductList = TicketStockVirtualMatrix::selectRaw('products.id as productId, products.name as productName, count(*) as stockQty')
            ->leftJoin('ticket_stocks', 'ticket_stock_virtual_matrices.ticket_stock_id', '=', 'ticket_stocks.id')
            ->leftJoin('products', 'ticket_stocks.product_id', '=', 'products.id')
            ->leftJoin('services', 'products.service_id', '=', 'services.id')
            ->leftJoin('sites', 'services.site_id', '=', 'sites.id')
            ->where('sites.id', '=', $siteId)
            ->where('ticket_stocks.cashier_id', '=', $cashierId)
            ->whereNull('ticket_stocks.deleted_at')
            ->whereNull('ticket_stock_virtual_matrices.used_at')
            ->groupBy('products.id', 'products.name');
        $_stockProductList = $_stockProductList->get();

        foreach ($_stockProductList as $_stockProduct) {
            $stockList[] = [
                'productId' => $_stockProduct->productId,
                'productName' => $_stockProduct->productName,
                'stockQty' => $_stockProduct->stockQty,
            ];
        }
        return $stockList;
    }


}
