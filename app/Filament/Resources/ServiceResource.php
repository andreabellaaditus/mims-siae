<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Product;
use App\Models\Service;
use App\Services\SiaeService;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\NavigationItem;
use App\Models\SlotDay;
use App\Models\ProductCategory;
use App\Services\SlotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Scopes\ActiveScope;
use Filament\Tables\Filters\Filter;

use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;

class ServiceResource extends Resource
{

    protected static ?string $model = Service::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $breadcrumb = '';

	protected static ?string $slug = 'services';

    public static function getModelLabel(): string
    {
        return __(self::getCurrentProductCategorySlug().'.model-label');
    }

    public static function getPluralModelLabel(): string
    {
        return __(self::getCurrentProductCategorySlug().'.plural-model-label');
    }

    public static function getNavigationLabel(): string
    {
        return __(self::getCurrentProductCategorySlug().'.navigation-label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('services.navigation-group');
    }

    private static function getCurrentProductCategoryId(): int | null
    {
        $product_category_id = request('product_category_id') ? request('product_category_id') : session('product_category_id');
        if ($product_category_id){
            session()->put('product_category_id',$product_category_id);
            return $product_category_id;
        }

        return null;
    }

    private static function getCurrentProductCategorySlug(): string | null
    {
        $product_category_id = self::getCurrentProductCategoryId();
        if ($product_category_id){
            return ProductCategory::find($product_category_id)->slug;
        }

        return null;
    }

    public static function getEloquentQuery(): Builder
    {
        $service = new Service;
        $product_category_id = self::getCurrentProductCategoryId();
        if ($product_category_id) {
            return parent::getEloquentQuery()->where('product_category_id', $product_category_id)->withoutGlobalScope(ActiveScope::class);
        }

        return $service->scopeNotArchived(parent::getEloquentQuery()->withoutGlobalScope(ActiveScope::class));
    }

    public static function form(Form $form): Form
    {
        $slotService = new SlotService();
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make(__(self::$slug.'.tabs.service'))
                            ->icon('heroicon-o-archive-box')
                            ->schema([
                                Forms\Components\Fieldset::make(__(self::$slug.'.fieldsets.basis_information'))
                                    ->schema([
                                        Forms\Components\Select::make('product_category_id')
                                            ->relationship('product_category', 'name')
                                            ->preload()
                                            ->default(self::getCurrentProductCategoryId())
                                            ->required()
                                            ->label(__(self::$slug.'.form.product_category_id')),
                                        Forms\Components\Select::make('site_id')
                                            ->relationship('site', 'name')
                                            ->preload()
                                            ->required()
                                            ->label(__(self::$slug.'.form.site_id')),
                                        Forms\Components\TextInput::make('code')
                                            ->required()
                                            ->maxLength(100)
                                            ->label(__(self::$slug.'.form.code')),
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(100)
                                            ->label(__(self::$slug.'.form.name')),
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->maxLength(100)
                                            ->label(__(self::$slug.'.form.slug')),

                                        Forms\Components\TextInput::make('negozio_id')
                                            ->numeric()
                                            ->label(__(self::$slug . '.form.negozio_id')),

                                        Forms\Components\Toggle::make('active')
                                            ->inline(false)
                                            ->default(true)
                                            ->label(__(self::$slug.'.form.active')),
                                        Forms\Components\Toggle::make('is_purchasable')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_purchasable')),
                                    ]),
                                Forms\Components\Fieldset::make(__(self::$slug.'.fieldsets.reservations'))
                                    ->schema([
                                        Forms\Components\Toggle::make('is_date')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_date')),
                                        Forms\Components\Toggle::make('is_hour')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_hour')),
                                        Forms\Components\Toggle::make('is_language')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_language')),
                                        Forms\Components\Toggle::make('is_pickup')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_pickup')),
                                        Forms\Components\Toggle::make('is_duration')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_duration')),
                                        Forms\Components\Toggle::make('is_pending')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_pending')),
                                        Forms\Components\Toggle::make('is_min_pax')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_min_pax')),
                                        Forms\Components\TextInput::make('min_pax')
                                            ->numeric()
                                            ->nullable()
                                            ->label(__(self::$slug.'.form.min_pax')),
                                        Forms\Components\Toggle::make('is_max_pax')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_max_pax')),
                                        Forms\Components\TextInput::make('max_pax')
                                            ->numeric()
                                            ->nullable()
                                            ->label(__(self::$slug.'.form.max_pax')),
                                        Forms\Components\TextInput::make('online_reservation_delay')
                                            ->numeric()
                                            ->nullable()
                                            ->label(__(self::$slug.'.form.online_reservation_delay')),
                                        Forms\Components\TextInput::make('closing_reservation')
                                            ->numeric()
                                            ->nullable()
                                            ->label(__(self::$slug.'.form.closing_reservation')),
                                    ]),
                                Forms\Components\Fieldset::make(__(self::$slug.'.fieldsets.archive'))
                                    ->schema([
                                        Forms\Components\Toggle::make('is_archived')
                                            ->inline(false)
                                            ->label(__(self::$slug.'.form.is_archived')),
                                        Forms\Components\DateTimePicker::make('archived_at')
                                            ->label(__(self::$slug.'.form.archived_at')),
                                        Forms\Components\TextInput::make('archived_by')
                                            ->numeric()
                                            ->columnSpan(2)
                                            ->label(__(self::$slug.'.form.archived_by')),
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make(__(self::$slug.'.tabs.notifications'))
                            ->icon('heroicon-o-bell')
                            ->schema([
                                Forms\Components\Repeater::make('service_notifications')
                                    ->hiddenLabel()
                                    ->relationship('service_notifications')
                                    ->schema([
                                        Forms\Components\TextInput::make('recipients')
                                            ->email()
                                            ->suffixIcon('heroicon-m-envelope')
                                            ->label(__(self::$slug.'.form.service_notifications.recipients')),
                                        Forms\Components\Select::make('notification_frequency')
                                            //->options(NotificationFrequency::active()->pluck('name', 'slug'))
                                            ->multiple()
                                            ->preload()
                                            ->searchable()
                                            ->label(__(self::$slug.'.form.service_notifications.notification_frequency_id')),
                                    ])
                                    ->afterStateUpdated(fn (Request $request, Forms\Get $get) => $request->request->add(['product_category_id' => $get('product_category_id')]))
                                    ->addActionLabel(__(self::$slug.'.form.service_notifications.add_notification_service'))
                                    ->reorderableWithButtons()
                                    ->collapsible()
                                    ->cloneable()
                                    ->columns(2)
                            ]),
                            Forms\Components\Tabs\Tab::make(__(self::$slug.'.tabs.slots'))
                            ->icon('heroicon-o-clock')
                            ->schema([
                                Forms\Components\Repeater::make('slots')
                                    ->relationship()
                                    ->hiddenLabel()
                                    ->schema([
                                        Forms\Components\Hidden::make('service_id')
                                            ->default(session('service_id')),
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
                                    ->afterStateUpdated(fn (Request $request, Forms\Get $get) => $request->request->add(['product_category_id' => $get('product_category_id')]))
                                    ->addActionLabel(__(self::$slug.'.form.slots.add_slot'))
                                    ->reorderableWithButtons()
                                    ->collapsible()
                                    ->cloneable()
                                    ->columns(2),
                            ]),
                    ])
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->headerActions([
                Tables\Actions\Action::make('Importa eventi siae')
                ->form([
                    Forms\Components\DatePicker::make('start_date')
                    ->default(date('d-m-Y'))
                    ->afterOrEqual(date('d-m-Y'))
                    ->label(__('global.from'))
                    ->required(),

                    Forms\Components\DatePicker::make('end_date')
                    ->default(Carbon::now()->addMonth()->format('d-m-Y'))
                    ->afterOrEqual(date('d-m-Y'))
                    ->label(__('global.to'))
                    ->required(),
                ])
                ->action(function (array $data): void {
                    $site_ids = auth()->user()->user_site->site_id;
                    if (isset($site_ids) && !empty($site_ids)) {
                        $siaeService = new SiaeService();
                        $token = $siaeService->getToken();

                        foreach ($site_ids as $site_id) {
                            $siaeService->getEventi($token, $site_id, $data['start_date'].' 00:00:00',  $data['end_date'].' 23:59:59');
                        }
                    }
                })

            ])
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->label(__(self::$slug.'.table.name')),
                Tables\Columns\TextColumn::make('site.name')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->label(__(self::$slug.'.table.site.name')),
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->label(__(self::$slug.'.table.code')),
                Tables\Columns\IconColumn::make('active')
                    ->sortable()
                    ->boolean()
                    ->label(__(self::$slug.'.table.active')),
                Tables\Columns\IconColumn::make('is_purchasable')
                    ->sortable()
                    ->boolean()
                    ->label(__(self::$slug.'.table.is_purchasable')),
                Tables\Columns\IconColumn::make('is_archived')
                    ->sortable()
                    ->boolean()
                    ->label(__(self::$slug.'.table.is_archived')),
            ])
            ->filters([
                Filter::make('is_archived')
                ->query(fn (Builder $query): Builder => $query->where('is_archived', 0))
                ->label(__(self::$slug.'.filters.is_archived')),
            ])
            ->actions([
                Tables\Actions\Action::make('products')
                    ->icon('heroicon-o-shopping-cart')
                    ->iconButton()
                    ->size(ActionSize::Large)
                    ->color('success')
                    ->badge(fn (Model $record): int => Product::where('service_id',$record->id)->withoutGlobalScope(ActiveScope::class)->count())
                    ->badgeColor('success')
                    ->url(fn (Model $record): string => ProductResource::getUrl('index', ['service_id' => $record->id])),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
