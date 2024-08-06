<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Product;
use App\Models\VirtualStoreSetting;
use App\Services\SlotService;
use App\Services\NotificationService;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;
    protected static ?string $breadcrumb = '';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeValidate(): void
    {
        if($this->data['related_products']){
            $record = Product::find($this->data['id']);

            if($record->related_products->count() == 0){
                $replica = Product::create($record->replicate()->toArray());
                foreach ($record->reduction_fields as $reductionField) {
                    $replica->reduction_fields()->save($reductionField);
                }

                foreach ($record->product_validities as $productValidity) {
                    $newProductValidity = $productValidity->replicate();
                    $replica->product_validities()->save($newProductValidity);
                }

                foreach ($record->sites as $site) {
                    $replica->sites()->save($site);
                }

                foreach ($record->reductions as $reduction) {
                    $replica->reductions()->save($reduction);
                }

                foreach ($record->slots as $slot) {
                    $newSlot = $slot->replicate();
                    $replica->slots()->save($newSlot);
                }

                foreach ($this->data['related_products'] as $related_product) {
                    $rel_prod = Product::find($related_product);
                    $replica->related_products()->save($rel_prod);
                }
                unset($this->data['related_products']);
                $vss = $record->virtual_store_settings->replicate()->toArray();
                $vss['product_id'] = $replica->id;
                VirtualStoreSetting::create($vss);
            }
        }


        $slotService = new SlotService();
        if(!$slotService->checkCorrectSlots($this->data['slots'])){
            $result = [
                'error' => 1,
                'title' => __('global.warning'),
                'color' => 'danger',
                'icon' => 'heroicon-m-x-circle',
                'body' => __('orders.slot-error')
            ];
            $notification = new NotificationService;
            $notification->getNotification($result);
            $this->halt();
        }
    }
}
