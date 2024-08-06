<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use App\Models\Service;
use Filament\Actions;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Illuminate\Database\Query\Builder;
use Filament\Tables;
use Livewire\Component;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;
    protected static ?string $breadcrumb = '';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            //->url(fn (): string => route('filament.admin.resources.services.create', ['product_category_id' => request('product_category_id')]))
            ->url(fn (): string => $this->getResource()::getUrl('create',['product_category_id' => session('product_category_id')]))
        ];
    }
}
