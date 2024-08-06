<?php

namespace App\Exports;

use App\Models\SiaeOrderItem;
use App\Services\OrderItemService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderItemsExport implements FromView
{
    public int $cashier_id;
    public $created_from;
    public $created_until;

    public function __construct($cashier_id, $created_from, $created_until)
    {
        $this->cashier_id = $cashier_id;
        $this->created_from = $created_from;
        $this->created_until = $created_until;
    }

    public function view(): View
    {
        $orderItemService = new OrderItemService();
        $res = $orderItemService->getListExport($this->cashier_id, $this->created_from, $this->created_until);
        return view('filament.exports.orders-list', [
            'items' => $res['items'],
            'total_by_product' => $res['grouped_by_product'],
            'total_by_paymenttype' => $res['grouped_by_payment_type']
        ]);
    }

}
