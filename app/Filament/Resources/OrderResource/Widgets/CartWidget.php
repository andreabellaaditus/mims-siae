<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\CartProduct;
use App\Models\Product;
use App\Services\OrderService;
use App\Models\Slot;
use Faker\Core\Number;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Forms;
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Illuminate\Support\HtmlString;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Livewire\Livewire;

use App\Services\CartProductService;

class CartWidget extends BaseWidget
{
    protected $listeners = ['refresh_cart' => '$refresh'];
    protected static ?string $slug = 'orders';

    public function table(Table $table): Table
    {
        $cartProductService = new CartProductService;
        $orderService = new OrderService;

        $site_id = session('site_id');
        $currentUser = $orderService->getCurrentUser($site_id);

        return $table
        ->query(
            $cartProductService->getProducts($currentUser->id, $site_id)
        )
        ->columns([
            Tables\Columns\TextColumn::make('name')
            ->extraAttributes(['class' => 'whitespace-normal'])
            ->label(__('global.name'))
            ->formatStateUsing(function(Product $product){
                $name = $product->name;
                foreach($product->related_products AS $rel_prod){
                    $name.= "<br>+ ".$rel_prod->name;
                }
                return new HtmlString($name);
            })
            ->url(function(Product $record){
                if($record->is_link){
                    return $record->product_link;
                }
            })
            ->openUrlInNewTab()
            ->color(fn(Product $record) => $record->is_link ? 'info' : 'default' ),

            Tables\Columns\TextInputColumn::make('qty')
            ->label(__('global.qty'))
            ->type('numeric')
            ->updateStateUsing(function (?string $state, Product $record, CartProductService $cartProductService) {
                $sub = $state - $record->qty;
                if($sub > 0){

                    for($i = 0 ; $i < $sub; $i++){

                        $existing_prod = $cartProductService->searchIdenticalProducts(['cart_id' => $record->cart_id, 'product_id' => $record->id]);

                        $date_service = null;
                        $hour_service = null;
                        if($existing_prod){
                            $date_service = $existing_prod->date_service;
                            $hour_service = $existing_prod->hour_service;
                        }

                        $data_cart_product = [
                            'cart_id' => $record->cart_id,
                            'product_id' => $record->id,
                            'date_service' => $date_service,
                            'hour_service' => $hour_service,
                        ];

                        $cartProductService->create($data_cart_product);
                    }

                }else{

                    for($i = 0 ; $i > $sub; $i--){
                        $cartProductService->deleteOne(['cart_id' => $record->cart_id, 'product_id' => $record->id]);
                    }

                }
                $this->dispatch('refresh_dates');

            })
            ,
            Tables\Columns\TextColumn::make('vat')
            ->label(__('global.vat'))
            ->formatStateUsing(function(Product $product){
                return $product->vat. "%";
            }),
            Tables\Columns\TextColumn::make('total')
            ->label(__('global.total'))
            ->numeric(
                decimalPlaces: 2,
                decimalSeparator: ','
            )
            ->money('EUR')

            ->formatStateUsing(function(Product $product){
                $price = $product->price_sale;
                foreach($product->related_products AS $rel_prod){
                    $price += $rel_prod->price_sale;
                }
                return number_format($price * $product->qty, 2, ','). " €";
            })
            ->description(function(Product $product){
                $price = $product->price_sale;
                foreach($product->related_products AS $rel_prod){
                    $price += $rel_prod->price_sale;
                }
                return number_format($price, 2, ','). " € x ".$product->qty;
            })
            ->summarize(Summarizer::make()
            ->using(function(CartProductService $cartProductService){
                return $cartProductService->getCartTotal(auth()->user()->id);
            }))
        ])
        ->heading(__(self::$slug.'.cart'))
        ->actions([

            Tables\Actions\Action::make('remove_qty')
            ->action(function ($record, CartProductService $cartProductService) {
                $cartProductService->deleteOne(['product_id' => $record->id, 'cart_id' => $record->cart_id]);
                $this->dispatch('refresh_dates');
            })
            ->label('')
            ->icon('heroicon-m-minus'),

            Tables\Actions\Action::make('add_qty')
            ->action(function ($record, CartProductService $cartProductService, Set $set) {

                $existing_prod = $cartProductService->searchIdenticalProducts(['cart_id' => $record->cart_id, 'product_id' => $record->id]);
                $date_service = null;
                $hour_service = null;
                $open_ticket = 1;
                if($existing_prod){
                    $date_service = $existing_prod->date_service;
                    $hour_service = $existing_prod->hour_service;
                    $open_ticket = $existing_prod->open_ticket;
                }

                $data_cart_product = [
                    'cart_id' => $record->cart_id,
                    'product_id' => $record->id,
                    'date_service' => $date_service,
                    'hour_service' => $hour_service,
                    'open_ticket' => $open_ticket,
                ];

                $cartProductService->create($data_cart_product);

                $this->dispatch('refresh_dates');
            })

            ->label('')
            ->icon('heroicon-m-plus'),

            Tables\Actions\Action::make('delete')
            ->requiresConfirmation()
            ->modalHeading(__('global.delete-confirmation'))
            ->modalDescription('')
            ->label('')
            ->icon('heroicon-m-trash')
            ->size(ActionSize::Large)
            ->action(function ($record, CartProductService $cartProductService) {

                $cartProductService->deleteProductGroup(['product_id' => $record->id, 'cart_id' => $record->cart_id]);
                $this->dispatch('refresh_dates');
            }),

            Tables\Actions\Action::make('is_cumulative')
            ->label('')
            ->icon(function ($record, CartProductService $cartProductService) {
                $res = $cartProductService->getProductGroup(['product_id' => $record->id, 'cart_id' => $record->cart_id]);
                $record->is_cumulative = $res->is_cumulative;
                $icon = ($res->is_cumulative) ?  'heroicon-m-user-group' : 'heroicon-o-user-group';
                return $icon;
            })
            ->size(ActionSize::Large)
            ->action(function ($record, CartProductService $cartProductService) {

                $cartProductService->switchIsCumulative(['product_id' => $record->id, 'cart_id' => $record->cart_id]);
                $this->dispatch('refresh_dates');
            })

        ])
        ->paginated(false);
    }

}
