<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Services\NotificationService;
use App\Services\SlotService;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;
    protected static ?string $breadcrumb = '';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index',['product_category_id' => session('product_category_id')]);
    }
    protected function beforeCreate(): void
    {
        $slotService = new SlotService();
        if(!$slotService->checkCorrectSlots($this->data['slots'])){
            $result = [
                'error' => 1,
                'title' => __('global.warning'),
                'color' => 'danger',
                'icon' => 'heroicon-m-x-circle',
                'body' => __('services.slot-error')
            ];
            $notification = new NotificationService;
            $notification->getNotification($result);
            $this->halt();
        }
    }
}
