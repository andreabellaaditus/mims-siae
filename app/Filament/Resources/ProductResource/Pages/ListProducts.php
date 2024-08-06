<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;
    protected static ?string $breadcrumb = '';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->url(
                    fn (): string => $this->getResource()::getUrl('create', [
                        'service_id' => request('service_id'),
                    ])
                ),
        ];
    }
}
