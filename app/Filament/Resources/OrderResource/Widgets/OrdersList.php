<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\SiaeOrderItem;
use App\Models\PaymentType;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Services\PaymentTypeService;
use App\Services\OrderService;
use App\Services\OrderItemService;
use App\Models\SiaeOrder;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Filters\Filter;
use Filament\Forms;
use Filament\Support\Enums\IconSize;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Filament\Forms\Get;
use Filament\Forms\Components\TimePicker;
use Illuminate\Http\Request;


class OrdersList extends BaseWidget
{
    protected $listeners = ['refresh_orders' => '$refresh'];
    protected int | string | array $columnSpan = 'full';
    protected static ?string $slug = 'orders';
    protected static ?string $url_export = 'export';
    public $cashier_id;
    public ?array $parameters;

    public function table(Table $table): Table
    {
        $payment_types = PaymentType::get();
        $orderItemService = new OrderItemService();


        return $table
            ->query(

                $orderItemService->getListBySite($this->cashier_id)

            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                ->label(__('global.date-creation'))
                ->dateTime('H:i')
                ->searchable(['order_items.created_at']),
                Tables\Columns\TextColumn::make('order.user.last_name')
                ->label(__('global.username'))
                ->searchable(["CONCAT(users.last_name, ' ', LEFT(users.first_name, 1), '.')"]),
                Tables\Columns\TextColumn::make('order.cashier.name')
                ->label(__('global.cashier'))
                ->searchable(['cashiers.name']),
                Tables\Columns\TextColumn::make('product.name')
                ->label(__('global.product'))
                ->searchable(['products.name']),
                Tables\Columns\TextColumn::make('qty')
                ->label(__('global.qty')),
                Tables\Columns\TextColumn::make('order.payment.payment_type.name')
                ->label(__(self::$slug.'.form.payment-type'))
                ->searchable(['payment_types.name']),
                Tables\Columns\TextColumn::make('price')
                ->label(__(self::$slug.'.unit-price'))
                ->numeric(
                    decimalPlaces: 2,
                    decimalSeparator: ','
                )
                ->money('EUR'),
                Tables\Columns\TextColumn::make('scans')
                ->formatStateUsing(function (SiaeOrderItem $record){
                    $scanned = 0;
                    foreach($record->scans AS $scan){
                        $scanned += $scan->is_scanned;
                    }
                    return $scanned."/".($record->product->max_scans * $record->qty);
                })

                ->label(__(self::$slug.'.scans')),
                Tables\Columns\TextColumn::make('order.notes')
                ->label(__('global.notes'))
                ->searchable(['orders.notes']),
                ])
            ->heading(__(self::$slug.'.list'))
            ->filters([
                Filter::make('created_at')
                    ->form([
                        TimePicker::make('created_from')
                            ->label(__('global.from'))
                            ->afterStateUpdated(function($state){
                                $this->parameters['created_from'] = $state;
                            }),
                        TimePicker::make('created_until')
                            ->label(__('global.to'))
                            ->afterStateUpdated(function($state){
                                $this->parameters['created_until'] = $state;
                            }),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $hour): Builder => $query->where('created_at', '>=', date('Y-m-d')." ".$hour),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $hour): Builder => $query->where('created_at', '<=', date('Y-m-d')." ".$hour),
                        );
                    })
                ])->deferFilters()
                ->filtersApplyAction(
                fn (Tables\Actions\Action $action) => $action
                    ->link()
                    ->label(__('global.apply-filters')),
                )
            ->headerActions([

                Tables\Actions\Action::make('export')
                ->icon('heroicon-m-arrow-down-tray')
                ->label(__(self::$slug.'.export-daily-report'))
                ->url(function(){
                    $this->parameters['cashier_id'] = $this->cashier_id;
                    $query_string = http_build_query($this->parameters);
                    $url_with_parameters = self::$url_export . '?' . $query_string;
                    return $url_with_parameters;
                })

            ])

            ->actions([
                Tables\Actions\Action::make('add_notes')
                ->form([
                    Forms\Components\MarkdownEditor::make('notes')
                    ->label(__('global.notes'))
                    ->default(fn (SiaeOrderItem $record) => $record->order->notes )
                ])
                ->label('')
                ->icon('heroicon-m-information-circle')
                ->iconSize(IconSize::Large)
                ->color('info')
                ->slideOver()
                ->modalContent(fn ($record): View => view(
                    'filament.resources.order-resource.detail-orderitem',
                    ['record' => $record],
                    ['payment_types' => $payment_types],
                ))
                ->action(function (array $data, $record): void {
                    $orderService = new OrderService();
                    $data_update = ['notes' => $data['notes']];
                    $orderService->update($record->order_id, $data_update);
                }),
            ]);

    }

    public function changePaymentType($payment_id, $payment_type)
    {
        $paymentService = new PaymentService();
        $conditions = ['id' => $payment_id];
        $data_update = ['payment_type_id' => $payment_type];
        $paymentService->update($conditions, $data_update);

    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::BelowContent;
    }
}
