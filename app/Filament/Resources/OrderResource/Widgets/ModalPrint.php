<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use Filament\Widgets\Widget;

class ModalPrint extends Widget
{
    protected $listeners = ['open_print' => 'openModal'];
    protected static string $view = 'filament.resources.order-resource.widgets.modal_print';
    protected int | string | array $columnSpan = 'full';
    public $order_id;

    public function openModal($order_id){
        $this->order_id = $order_id;

    }

}
