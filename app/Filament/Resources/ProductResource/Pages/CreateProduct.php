<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Services\ProductService;
use App\Services\SlotService;
use App\Services\NotificationService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
    protected static ?string $breadcrumb = '';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $record = static::getModel()::create($data);

        $productService = new ProductService($record);
        if(isset($data['ticket_types']) ){
            $productService->createVirtualStoreSettingsRelationShip($data['ticket_types']);
        }

        return $record;
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
                'body' => __('products.slot-error')
            ];
            $notification = new NotificationService;
            $notification->getNotification($result);
            $this->halt();
        }
    }




}
