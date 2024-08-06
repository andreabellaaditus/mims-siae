<?php

namespace App\Filament\Resources;

use App\Enums\MatrixGenerationType;
use App\Enums\SaleChannel;
use App\Enums\SaleClient;
use App\Enums\ValidityPeriod;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\ProductValidity;
use App\Models\TicketType;
use App\Models\Reduction;
use App\Models\ReductionField;
use App\Models\Service;
use App\Models\Site;
use App\Models\SlotDay;
use App\Services\SlotService;
use App\Services\ProductsService;
use Spatie\Permission\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\Request;
use LaraZeus\MatrixChoice\Components\Matrix;
use App\Models\Scopes\ActiveScope;
use App\Models\VirtualStoreSetting;
use App\Services\SiaeService;
use Filament\Forms\Get;
use Filament\Forms\Set;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $breadcrumb = '';
    protected static ?string $slug = 'products';

    private static function getCurrentService(): Model | null
    {
        $service_id = request('service_id') ? request('service_id') : session('service_id');
        if ($service_id){
            session()->put('service_id',$service_id);
            return Service::with('product_category')->withoutGlobalScope(ActiveScope::class)->find($service_id);
        }

        return null;
    }

    public static function getPluralModelLabel(): string
    {
        $service = self::getCurrentService();
        return $service->product_category->name." - ".$service->name." - ".__(self::$slug.'.plural-model-label');
    }

    public static function getModelLabel(): string
    {
        $service = self::getCurrentService();
        return $service->product_category->name." - ".$service->name." - ".(__(self::$slug.'.model-label'));
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('service_id', session('service_id'))->withoutGlobalScope(ActiveScope::class);
    }

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        $ProductsService = new ProductsService;
        $slotService = new SlotService();
        return $form
            ->schema([
                Forms\Components\Hidden::make('service_id')
                ->default(session('service_id')),
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make(__(self::$slug.'.tabs.basis_information'))
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Section::make(__(self::$slug.'.sections.basis_information'))
                                    ->description(__(self::$slug.'.sections.required'))
                                    ->icon('heroicon-o-information-circle')
                                    ->schema([
                                        Forms\Components\TextInput::make('product_id')
                                        ->hidden(),
                                        Forms\Components\TextInput::make('code')
                                            ->required()
                                            ->maxLength(100)
                                            ->label(__(self::$slug.'.form.code')),
                                        Forms\Components\TextInput::make('article')
                                            ->required()
                                            ->maxLength(100)
                                            ->label(__(self::$slug.'.form.article')),
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(100)
                                            ->label(__(self::$slug.'.form.name')),
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->maxLength(100)
                                            ->label(__(self::$slug.'.form.slug')),
                                        Forms\Components\Toggle::make('active')
                                            ->inline(false)
                                            ->default(true)
                                            ->label(__(self::$slug.'.form.active')),
                                        Forms\Components\Toggle::make('deliverable')
                                            ->inline(false)
                                            ->default(true)
                                            ->label(__(self::$slug.'.form.deliverable')),
                                        Forms\Components\Toggle::make('printable')
                                            ->inline(false)
                                            ->default(true)
                                            ->label(__(self::$slug.'.form.printable')),
                                        Forms\Components\Toggle::make('billable')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.billable')),
                                        Forms\Components\Toggle::make('exclude_slotcount')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.exclude-slotcount')),
                                        Forms\Components\Toggle::make('is_siae')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is-siae')),
                                    ])
                                ->columns(2),

                                Forms\Components\Section::make(__(self::$slug.'.sections.seats_and_scans'))
                                    //->description(__(self::$slug.'.sections.required'))
                                    ->icon('heroicon-o-calendar')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_date')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_date')),
                                        Forms\Components\Toggle::make('is_hour')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_hour')),
                                        Forms\Components\Toggle::make('is_name')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_name')),
                                        Forms\Components\Toggle::make('is_card')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_card')),
                                        Forms\Components\Toggle::make('is_link')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_link')),
                                        Forms\Components\TextInput::make('product_link')
                                            ->maxLength(255)
                                            ->label(__(self::$slug.'.form.product_link')),
                                        Forms\Components\Toggle::make('has_additional_code')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.has_additional_code')),
                                        Forms\Components\TextInput::make('max_scans')
                                            ->numeric()
                                            ->step(1)
                                            ->default(1)
                                            ->label(__(self::$slug.'.form.max_scans')),
                                        Forms\Components\TextInput::make('qr_code')
                                            ->maxLength(255)
                                            ->label(__(self::$slug.'.form.qr_code')),
                                        Forms\Components\TextInput::make('online_reservation_delay')
                                            ->numeric()
                                            ->step(1)
                                            ->default(0)
                                            ->label(__(self::$slug.'.form.online_reservation_delay')),
                                    ])->columns(2)
                            ])
                            ->columns(2),

                        Forms\Components\Tabs\Tab::make(__(self::$slug.'.tabs.matrices'))
                            ->icon('heroicon-o-code-bracket-square')
                            ->schema([
                                Forms\Components\Section::make(__(self::$slug.'.sections.matrices'))
                                    ->description(__(self::$slug.'.sections.required'))
                                    ->icon('heroicon-o-code-bracket-square')
                                    ->schema([

                                        Forms\Components\Select::make('matrix_generation_type')
                                            ->options(MatrixGenerationType::class)
                                            ->required()
                                            ->hidden(fn ($record) => ($record) ? true : false)
                                            ->label(__(self::$slug.'.form.matrix_generation_type')),

                                        Forms\Components\Select::make('ticket_types')
                                            ->label(__(self::$slug.'.form.ticket_type'))
                                            ->required()
                                            ->reactive()
                                            ->dehydrated()
                                            ->hidden(fn ($record) => ($record) ? true : false)
                                            ->options(TicketType::pluck('name', 'slug'))
                                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                                $service = Service::find(session('service_id'));
                                                $set('matrix_prefix', $state."/".$service->site->matrix_suffix);
                                            }),

                                        Forms\Components\TextInput::make('matrix_prefix')
                                            ->readonly()
                                            ->afterStateHydrated(function (Forms\Components\TextInput $component, Product $record = null) {
                                                if($record && (self::getCurrentService()->product_category->slug === 'tickets' || self::getCurrentService()->product_category->slug === 'site-events' )){
                                                    $component->state($record->virtual_store_settings->value);
                                                }
                                            })
                                            ->label(__(self::$slug.'.form.matrix_prefix'))
                                    ])
                                ->columns(3),
                            ])
                            ->visible(fn (Forms\Get $get) => self::getCurrentService()->product_category->slug === 'tickets'  || self::getCurrentService()->product_category->slug === 'site-events')
                            ->columns(2),
                        Forms\Components\Tabs\Tab::make(__(self::$slug.'.tabs.prices'))
                            ->icon('heroicon-o-currency-euro')
                            ->schema([
                                Forms\Components\Section::make(__(self::$slug.'.sections.prices'))
                                    ->description(__(self::$slug.'.sections.required'))
                                    ->icon('heroicon-o-currency-euro')
                                    ->schema([
                                        Forms\Components\TextInput::make('price_sale')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->required()
                                            ->suffix('€')
                                            ->label(__(self::$slug.'.form.price_sale')),
                                        Forms\Components\TextInput::make('price_purchase')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->required()
                                            ->suffix('€')
                                            ->label(__(self::$slug.'.form.price_purchase')),
                                        Forms\Components\TextInput::make('price_web')
                                            ->numeric()
                                            ->required()
                                            ->inputMode('decimal')
                                            ->suffix('€')
                                            ->label(__(self::$slug.'.form.price_web')),
                                        Forms\Components\TextInput::make('vat')
                                            ->numeric()
                                            ->step(1)
                                            ->default(0)
                                            ->suffix('%')
                                            ->label(__(self::$slug.'.form.vat')),
                                        Forms\Components\Toggle::make('price_per_pax')
                                            ->inline(false)
                                            ->default(true)
                                            ->label(__(self::$slug.'.form.price_per_pax')),
                                        Forms\Components\TextInput::make('num_pax')
                                            ->numeric()
                                            ->step(1)
                                            ->default(1)
                                            ->label(__(self::$slug.'.form.num_pax')),
                                    ])->columns(2),
                            ])
                            ->columns(2),
                        Forms\Components\Tabs\Tab::make(__(self::$slug.'.tabs.validities'))
                            ->icon('heroicon-o-check-circle')
                            ->schema([
                                Forms\Components\Section::make(__(self::$slug.'.sections.validities'))
                                    ->description(__(self::$slug.'.sections.required'))
                                    ->icon('heroicon-o-check-circle')
                                    ->schema([
                                        Forms\Components\Select::make('validity_from_issue_unit')
                                            ->options(ValidityPeriod::class)
                                            ->required()
                                            ->label(__(self::$slug.'.form.validity_from_issue_unit')),
                                        Forms\Components\TextInput::make('validity_from_issue_value')
                                            ->numeric()
                                            ->step(1)
                                            ->required()
                                            ->label(__(self::$slug.'.form.validity_from_issue_value')),
                                        Forms\Components\Select::make('validity_from_burn_unit')
                                            ->options(ValidityPeriod::class)
                                            ->required()
                                            ->label(__(self::$slug.'.form.validity_from_burn_unit')),
                                        Forms\Components\TextInput::make('validity_from_burn_value')
                                            ->numeric()
                                            ->step(1)
                                            ->required()
                                            ->label(__(self::$slug.'.form.validity_from_burn_value')),
                                        Forms\Components\Repeater::make('product_validities')
                                            ->label(__(self::$slug.'.sections.validities'))
                                            ->relationship()
                                            ->schema([
                                                Forms\Components\DateTimePicker::make('start_validity')
                                                    ->required()
                                                    ->format('Y-m-d H:i:s')
                                                    ->label(__(self::$slug.'.form.start_validity')),
                                                Forms\Components\DateTimePicker::make('end_validity')
                                                    ->required()
                                                    ->format('Y-m-d H:i:s')
                                                    ->label(__(self::$slug.'.form.end_validity'))
                                            ])
                                            ->addActionLabel(__(self::$slug.'.form.add_validity'))
                                            ->reorderableWithButtons()
                                            ->collapsible()
                                            ->cloneable()
                                            ->afterStateUpdated(fn (Request $request, Forms\Get $get) => $request->request->add(['service_id' => $get('service_id')]))
                                            ->columns(2)
                                            ->columnSpan(2)
                                    ])->columns(2)
                            ])
                            ->columns(2),

                            Forms\Components\Tabs\Tab::make(__(self::$slug.'.tabs.slots'))
                            ->icon('heroicon-o-clock')
                            ->schema([
                                Forms\Components\Section::make(__(self::$slug.'.sections.slots'))
                                ->description(__(self::$slug.'.sections.required'))
                                ->icon('heroicon-o-clock')

                                ->schema([
                                    Forms\Components\Repeater::make('slots')
                                        ->hiddenLabel()
                                        ->relationship()
                                        ->schema([
                                            Forms\Components\Select::make('slot_days')
                                                ->options(
                                                    fn($get) => $slotService->getProductDays($get))
                                                ->getOptionLabelsUsing(fn (array $values): array => SlotDay::whereIn('slug', $values)->pluck('name', 'slug')->toArray())
                                                ->multiple()
                                                ->required()
                                                ->preload()
                                                ->searchable()
                                                ->label(__(self::$slug.'.form.slots.slot_day_id')),
                                            Forms\Components\Select::make('slot_type')
                                                ->options([
                                                    'free' => 'Libero',
                                                    'repeated' => 'Ripetuto',
                                                ])
                                                ->live()
                                                ->required()
                                                ->label(__(self::$slug.'.form.slots.slot_type')),
                                            Forms\Components\TextInput::make('duration')
                                                ->numeric()
                                                ->step(1)
                                                ->required()
                                                ->suffix('min')
                                                ->visible(fn (Forms\Get $get) => $get('slot_type') === 'repeated')
                                                ->label(__(self::$slug.'.form.slots.duration')),
                                            Forms\Components\TagsInput::make('hours')
                                                ->placeholder(__(self::$slug.'.form.slots.hours'))
                                                ->suggestions(['09:00','10:00','10:15'])
                                                ->required()
                                                ->visible(fn (Forms\Get $get) => $get('slot_type') === 'free')
                                                //->columnSpan(2)
                                                ->label(__(self::$slug.'.form.slots.hours')),
                                            Forms\Components\TextInput::make('advance_tolerance')
                                                ->numeric()
                                                ->required()
                                                ->step(1)
                                                ->default(15)
                                                ->suffix('min')
                                                ->label(__(self::$slug.'.form.slots.advance_tolerance')),

                                            Forms\Components\TextInput::make('delay_tolerance')
                                                    ->numeric()
                                                    ->required()
                                                    ->step(1)
                                                    ->default(15)
                                                    ->suffix('min')
                                                    ->label(__(self::$slug.'.form.slots.delay_tolerance')),

                                            Forms\Components\TextInput::make('availability')
                                                ->numeric()
                                                ->required()
                                                ->step(1)
                                                ->suffix('pax')
                                                ->label(__(self::$slug.'.form.slots.availability')),

                                        ])
                                        ->addActionLabel(__(self::$slug.'.form.slots.add_slot'))
                                        ->reorderableWithButtons()
                                        ->collapsible()
                                        ->cloneable()
                                        ->columns(2),
                                    ])
                        ]),

                        Forms\Components\Tabs\Tab::make(__(self::$slug.'.tabs.sales_matrix'))
                            ->icon('heroicon-o-shopping-cart')
                            ->schema([
                                Forms\Components\Section::make(__(self::$slug.'.sections.sales_matrix'))
                                    ->description(__(self::$slug.'.sections.required'))
                                    ->icon('heroicon-o-shopping-cart')
                                    ->schema([
                                       Matrix::make('sale_matrix')
                                            ->label('Matrice di vendita')
                                            ->asCheckbox()
                                            ->columnData(__('enums.sale-channels'))
                                            ->rowData(__('enums.sale-clients'))
                                            ->rowSelectRequired(false)
                                    ])
                                    ->model(static::getModel())
                            ])
                            ->columns(2),
                        Forms\Components\Tabs\Tab::make(__(self::$slug.'.tabs.document_check'))
                            ->icon('heroicon-o-document-magnifying-glass')
                            ->schema([
                                Forms\Components\Section::make(__(self::$slug.'.sections.document_check'))
                                    //->description(__(self::$slug.'.sections.required'))
                                    ->icon('heroicon-o-document-magnifying-glass')
                                    ->schema([
                                        Forms\Components\Toggle::make('check_document')
                                            ->inline(false)
                                            ->live()
                                            ->afterStateUpdated(fn (Request $request, Forms\Get $get) => $request->request->add(['service_id' => $get('service_id')]))
                                            ->label(__(self::$slug.'.form.check_document')),
                                            Forms\Components\Select::make('reductions')
                                            ->multiple()
                                            ->relationship('reductions', 'name')
                                            ->preload()
                                            ->required()
                                            ->visible(fn (Forms\Get $get) => $get('check_document') === true)
                                            ->label(__(self::$slug.'.form.reductions')),
                                        Forms\Components\CheckboxList::make('reduction_fields')
                                            ->columns(4)
                                            ->relationship('reduction_fields', 'name')
                                            ->gridDirection('row')
                                            ->visible(fn (Forms\Get $get) => $get('check_document') === true)
                                            ->columnSpan(2)
                                            ->label(__(self::$slug.'.form.reduction_fields')),
                                    ])->columns(2)
                            ])
                            ->columns(2),
                        Forms\Components\Tabs\Tab::make(__(self::$slug.'.tabs.supplier'))
                            ->icon('heroicon-o-tag')
                            ->schema([
                                Forms\Components\Section::make(__(self::$slug.'.sections.supplier'))
                                    //->description(__(self::$slug.'.sections.required'))
                                    ->icon('heroicon-o-tag')
                                    ->schema([
                                        Forms\Components\Toggle::make('has_supplier')
                                            ->inline(false)
                                            ->live()
                                            ->afterStateUpdated(fn (Request $request, Forms\Get $get) => $request->request->add(['service_id' => $get('service_id')]))
                                            ->label(__(self::$slug.'.form.has_supplier')),
                                        Forms\Components\Select::make('supplier_id')
                                            ->relationship('supplier', 'email')
                                            ->preload()
                                            ->visible(fn (Forms\Get $get) => $get('has_supplier') === true)
                                            ->label(__(self::$slug.'.form.supplier_id')),
                                    ])->columns(2)
                            ])
                            ->columns(2),
                        Forms\Components\Tabs\Tab::make(__(self::$slug.'.tabs.cumulatives'))
                            ->icon('heroicon-o-document-duplicate')
                            ->schema([
                                Forms\Components\Section::make(__(self::$slug.'.sections.cumulatives'))
                                    //->description(__(self::$slug.'.sections.required'))
                                    ->icon('heroicon-o-document-duplicate')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_cumulative')
                                        ->inline(false)
                                        ->live()
                                        ->afterStateUpdated(fn (Request $request, Forms\Get $get) => $request->request->add(['service_id' => $get('service_id')]))
                                        ->label(__(self::$slug.'.form.is_cumulative')),

                                        Forms\Components\Repeater::make('product_cumulatives')
                                            ->label('')
                                            ->relationship()
                                            ->schema([
                                                Forms\Components\Select::make('site_id')
                                                ->relationship('site', 'name')
                                                //->multiple()
                                                ->preload()
                                                ->required()
                                                ->label(__(self::$slug.'.form.product_cumulatives.name')),
                                                Forms\Components\TextInput::make('max_scans')
                                                ->required()
                                                ->integer()
                                                ->label(__(self::$slug.'.form.product_cumulatives.max_scans'))
                                            ])
                                            ->visible(fn (Forms\Get $get) => $get('is_cumulative') === true)
                                            ->columns(2)
                                            ->afterStateUpdated(fn (Request $request, Forms\Get $get) => $request->request->add(['service_id' => $get('service_id')]))
                                            ->columnSpan(2)
/*
                                        Forms\Components\Select::make('sites')
                                        ->multiple()
                                        ->relationship('sites', 'name')
                                        ->preload()
                                        ->required()
                                        ->visible(fn (Forms\Get $get) => $get('is_cumulative') === true)
                                        ->label(__(self::$slug.'.form.product_cumulatives.name')),*/

                                    ])->columns(2)
                            ])
                            ->columns(2),
                        Forms\Components\Tabs\Tab::make(__(self::$slug.'.tabs.notes'))
                            ->icon('heroicon-o-pencil-square')
                            ->schema([
                                Forms\Components\Section::make(__(self::$slug.'.sections.notes'))
                                    //->description(__(self::$slug.'.sections.required'))
                                    ->icon('heroicon-o-pencil-square')
                                    ->schema([
                                        Forms\Components\Textarea::make('notes')
                                            ->columnSpan(2)
                                            ->label(__(self::$slug.'.form.notes')),
                                    ])
                            ])
                            ->columns(2),

                        Forms\Components\Tabs\Tab::make(__(self::$slug.'.tabs.related_products'))
                            ->icon('heroicon-o-link')
                            ->schema([
                                Forms\Components\Section::make(__(self::$slug.'.sections.related_products'))
                                    ->icon('heroicon-o-link')
                                    ->schema([
                                        Forms\Components\Select::make('related_products')
                                        ->label(__(self::$slug.'.form.related_products'))
                                        ->multiple()
                                        ->relationship('related_products', 'name')
                                        ->options(fn ($record) => $ProductsService->getBySite($record->id))
                                        ->preload()
                                    ])
                            ])
                            ->hidden(fn ($record) => ($record) ? false : true)
                            ->columns(2),
                    ])
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                /*Tables\Columns\TextColumn::make('service.product_category.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('service.name')
                    ->searchable()
                    ->sortable(),*/
                Tables\Columns\TextColumn::make('code')
                    ->label(__(self::$slug.'.table.code'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('article')
                    ->label(__(self::$slug.'.table.article'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__(self::$slug.'.table.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_sale')
                    ->label(__(self::$slug.'.table.price_sale'))
                    ->money('EUR'),
                Tables\Columns\TextColumn::make('price_purchase')
                    ->label(__(self::$slug.'.table.price_purchase'))
                    ->money('EUR'),
                Tables\Columns\IconColumn::make('active')
                    ->label(__(self::$slug.'.table.active'))
                    ->sortable()
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ReplicateAction::make()->iconButton()->size(ActionSize::Large)
                ->after(function (Product $replica, Product $record): void {

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

                    $vss = $record->virtual_store_settings->replicate()->toArray();
                    $vss['product_id'] = $replica->id;
                    VirtualStoreSetting::create($vss);

                }),

                Tables\Actions\EditAction::make()->iconButton()->size(ActionSize::Large),
                Tables\Actions\DeleteAction::make()->iconButton()->size(ActionSize::Large),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }



    public static function getServiceId(): int
    {
        return self::service()->id;
    }
}
