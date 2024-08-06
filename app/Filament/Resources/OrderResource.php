<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\SiaeOrder;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Service;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\User;
use App\Models\OrderType;
use App\Models\Site;
use App\Models\SiaeOrderItem;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;
use Filament\Actions;
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\View;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Widgets;
use App\Filament\Resources\OrderResource\Widgets\CartWidget;
use App\Filament\Resources\OrderResource\Widgets\InsertProduct;
use App\Filament\Resources\OrderResource\Widgets\Slots;
use App\Services\NavigationService;
use Filament\Support\Enums\Alignment;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderItemsExport;

class OrderResource extends Resource
{
    protected static ?string $model = SiaeOrder::class;

    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $breadcrumb = '';

    protected static ?string $slug = 'orders';

    private static function getCurrentService(): Site | null
    {
        $site_id = request('site_id') ? request('site_id') : session('site_id');
        if ($site_id){
            session()->put('site_id',$site_id);
            return Site::find($site_id);
        }

        return null;
    }

    public static function getModelLabel(): string
    {
        $site = self::getCurrentService();
        return __(self::$slug.'.model-label')." - ".$site->name;
    }

    public static function getPluralModelLabel(): string
    {
        return __(self::$slug.'.plural-model-label');
    }

    public static function getNavigationLabel(): string
    {
        return __(self::$slug.'.navigation-label');
    }

    public static function getNavigationGroup(): ?string
    {
        $navigationService = new NavigationService;
        $navigationGroupSlug = $navigationService->getNavigationGroupSlug(self::$slug);
        return __('navigation.'.$navigationGroupSlug);
    }

    public static function getNavigationSort(): ?int
    {
        $navigationService = new NavigationService;
        $navigationSort = $navigationService->getNavigationSort(self::$slug);
        return $navigationSort;
    }

    public function export()
    {
        $created_from = request('created_from');
        $created_until = request('created_until');
        $cashier_id = request('cashier_id');
        return Excel::download(new OrderItemsExport($cashier_id, $created_from, $created_until), 'report_giornaliero_'.date('YmdHis').'.xlsx');
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Hidden::make('order_type_id')
            ->default(request('type')),
            Forms\Components\Hidden::make('site_id')
            ->default(self::getCurrentService()->id),
            Forms\Components\Section::make()
            ->schema([
                Forms\Components\Hidden::make('siae_order_id')->default(0),
                Forms\Components\Select::make('payment_type_id')
                ->relationship(name: 'payment_type', titleAttribute: 'name')
                ->preload()
                ->required()
                ->label(__(self::$slug.'.form.payment-type'))
                ->columnSpan(1),

                Forms\Components\Fieldset::make(__('global.send-mail'))
                    ->schema([
                        Toggle::make('send_mail')
                        ->live()
                        ->dehydrated()
                        ->label(__('global.enable-send-mail')),

                        Forms\Components\TextInput::make('email_to')
                        ->label('Email')
                        ->email()
                        ->maxLength(255)
                        ->visible(fn (Forms\Get $get) => $get('send_mail') === true)
                        ->suffixIcon('heroicon-m-envelope-open')
                    ])->columns(1)->columnSpan(1)

            ])
            ->model(SiaeOrderItem::class)
            ->columns(2)

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
