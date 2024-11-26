<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Pages\ScanQrCode as PagesScanQrCode;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Filament\Notifications\Notification;
use App\Models\Product;
use App\Models\CashierRegisterClosure;
use App\Models\Payment;
use App\Models\SiaeOrderItem;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\SiaeOrder;
use App\Models\OrderType;
use App\Models\Site;
use App\Models\Safe;
use App\Models\SiaeOrderItemReduction;
use App\Models\SiaeProductHolder;
use App\Models\Cashier;
use App\Filament\Resources\OrderResource\Widgets\OrdersList;
use App\Filament\Resources\OrderResource\Widgets\Slots;
use App\Filament\Resources\OrderResource\Widgets\InsertProduct;
use App\Filament\Resources\OrderResource\Widgets\CartWidget;
use App\Filament\Resources\OrderResource\Widgets\ModalPrint;
use App\Filament\Resources\OrderResource\Widgets\ReductionFields;
use App\Filament\Resources\OrderResource\Widgets\ScanQrCode;
use App\Models\PaymentType;
use App\Models\UserSite;
use App\Models\SiaeScan;
use Filament\Forms\Get;
use Filament\Forms\Set;

use App\Services\CartProductService;
use App\Services\OrderService;
use App\Services\OrderItemService;
use App\Services\CartService;
use App\Services\UserService;
use App\Services\ProductService;
use App\Services\NotificationService;
use App\Services\PaymentService;
use App\Services\PaymentTypeService;
use App\Services\CashierService;
use App\Services\SiaeService;
use App\Services\FileService;
use App\Services\StockService;
use App\Services\OrderItemStatusService;
use App\Services\OrderStatusService;

use App\Http\Helpers\Functions;
use App\Models\ProductCategory;
use App\Models\SafeOperation;
use App\Models\DocumentType;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Validator;

use Filament\Support\RawJs;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
    protected static ?string $slug = 'orders';

    protected $listeners = ['refresh_reduction_fields' => '$refresh'];


    protected function getRedirectUrl(): string
    {
        $record = $this->getRecord();
        return $this->getResource()::getUrl('create', ['site_id' => $record->site_id]);
    }

    protected function getFormActions(): array
    {

        return [

            Actions\Action::make('Crea ordine')->action('create')
            ->label(__(self::$slug.'.form.create'))
            ->icon('heroicon-m-check')
            ->extraAttributes(['class' => 'btnOrderForm'])
            ->hidden(function(){
                $cashierService = new CashierService;
                $orderService = new OrderService;
                $site_id = request('site_id') ? request('site_id') : session('site_id');
                return ($cashierService->hasOpenDesk($orderService->getCurrentUser($site_id)->id, $site_id)) ?  false : true ;
            }),
            Actions\Action::make(self::$slug.'.refresh-orders-table')
            ->label(__(self::$slug.'.refresh-orders-table'))
            ->action(function(){
                $this->dispatch('refresh_orders');
            })
            ->icon('heroicon-m-arrow-path')
            ->color('info')
        ];
    }


    protected function getHeaderActions(): array
    {
        $cashierService = new CashierService;
        $site_id = session('site_id');
        $listCashUsers = $cashierService->getCashiersBySite($site_id);

        $orderService = new OrderService;
        $currentUser = $orderService->getCurrentUser($site_id);

        $cashierRegisterClosure['currentCashClosurePayments'] = array();
        ($cashierService->hasOpenDesk($currentUser->id, $site_id)) ?  $cashierRegisterClosure = $cashierService->getClosureByCashier($site_id) : '' ;

        return [
            Actions\Action::make('Svuota carrello')
            ->label(__(self::$slug.'.empty-cart'))
            ->icon('heroicon-m-shopping-cart')
            ->color('gray')
            ->action(function () {
                $cartService = new CartService;
                $cartProductService = new CartProductService;

                $site_id = request('site_id') ? request('site_id') : session('site_id');
                $orderService = new OrderService;
                $currentUser = $orderService->getCurrentUser($site_id);
                $select_cart = $cartService->getCart($currentUser->id);
                if($select_cart){
                    $cartProductService->emptyByCartId($select_cart->id);
                    $cartService->empty($select_cart->id);

                    $this->dispatch('refresh_cart');
                    $this->dispatch('refresh_dates');
                }
            }),

            // cambio utente
            Actions\Action::make('changeUser')
            ->icon('heroicon-m-user')
            ->label(function (){

                $site_id = request('site_id') ? request('site_id') : session('site_id');
                $orderService = new OrderService;
                $currentUser = $orderService->getCurrentUser($site_id);
                return new HtmlString(__(self::$slug.'.change-user')." <br> (<b>". $currentUser->first_name. " ". $currentUser->last_name."</b>)");
            })
            ->color('info')
            ->form([
                Radio::make('current_user_id')
                ->label(new HtmlString("<h1 class='text-xl font-bold'>".__(self::$slug.'.cashier.select-cashier')."</h1>"))
                ->options($listCashUsers)
                ->afterStateUpdated(function (Set $set, ?string $state, OrderService $orderService) {
                    $site_id = session('site_id');
                    $orderService->setCurrentUserSession($site_id, $state);

                    $title = __(self::$slug.'.cashier.successfully-selected');
                    $message = __(self::$slug.'.cashier.proceed');
                    $responseJson = [
                        'title' => $title,
                        'body' => $message,
                        'color' => 'success',
                        'icon' => 'heroicon-m-check-circle'
                    ];

                    $notification = new NotificationService;
                    $notification->getNotification($responseJson);
                }),
            ])
            ->hidden(function(){

                return !auth()->user()->hasRole('Amministratore');

            }),

            // apertura cassa
            Actions\Action::make('openCashier')
            ->label(function(){
                    $orderService = new OrderService;
                    $cashierService = new CashierService;
                    $site_id = request('site_id') ? request('site_id') : session('site_id');
                    $currentUser = $orderService->getCurrentUser($site_id);
                    return ($cashierService->hasAnotherOpenDesk($currentUser->id)) ?  __(self::$slug.'.cashier.close-other') :  __(self::$slug.'.cashier.cashier-opening') ;
                }
            )

            ->form([
                Hidden::make('site_id')
                ->default($site_id),
                Radio::make('cashier_id')
                ->label(new HtmlString("<h1 class='text-xl font-bold'>".__(self::$slug.'.cashier.select-cashier')."</h1>"))
                ->options($cashierService->getForSelect($site_id))
                ->reactive()
                ->afterStateUpdated(function (Set $set, ?string $state, CashierService $cashierService) {
                    $set('closure_cash_amount_registered', number_format($cashierService->getAmountLastClosure($state), 2,'.',''));
                }),

                Fieldset::make('Controllo contanti')
                ->label('')
                ->schema([

                    Placeholder::make('Controllo contanti')->hiddenLabel()
                    ->content(new HtmlString(__(self::$slug . '.cashier.check-cash-drawer-desc')))
                    ->columnSpan(2),

                    TextInput::make('closure_cash_amount_registered')
                    ->label(__(self::$slug . '.cashier.closure-cash-amount-registered'))
                    ->numeric()
                    ->inputMode('decimal')
                    ->readonly()
                    ->suffixIcon('heroicon-o-currency-euro')
                    ->default(fn (Get $get) => number_format($cashierService->getAmountLastClosure($get('cashier_id')), 2,'.',''))
                    ->columnSpan(1),

                    TextInput::make('opening_cash_amount_registered')
                    ->label(__(self::$slug . '.cashier.opening-cash-amount-registered'))
                    ->live(onBlur: true)
                    ->numeric()
                    ->inputMode('decimal')
                    ->suffixIcon('heroicon-o-currency-euro')
                    ->prefixIcon(function(Get $get, $state){
                        if($get('closure_cash_amount_registered') == $state){
                            return 'heroicon-m-check-circle';
                        }else{
                            return 'heroicon-m-x-circle';
                        }
                    })
                    ->prefixIconColor(function(Get $get, $state){
                        if($get('closure_cash_amount_registered') == $state){
                            return 'success';
                        }else{
                            return 'danger';
                        }
                    })
                    ->columnSpan(1)
                ])
                ->hidden(fn(callable $get) => $get('cashier_id') == 0),

                Textarea::make('opening_notes')
                ->label(__('global.notes'))
                ->hidden(fn(callable $get) => $get('cashier_id') == 0),

            ])
            ->action(function (array $data): void {
                $site = Site::find(request('site_id') ? request('site_id') : session('site_id'));
                $status = 'error';
                $cashierService = new CashierService;
                $orderService = new OrderService;
                $currentUser = $orderService->getCurrentUser($site->id);
                try {
                    $cashierId = $data['cashier_id'];
                    $openingCashAmountLastClosure = $data['closure_cash_amount_registered'] ?? "0.00";
                    $openingCashAmountRegistered = $data['opening_cash_amount_registered'] ?? "0.00";
                    $openingNotes = $data['opening_notes'];

                    $activeCashDesk = $cashierService->checkAndAddCashDesk($currentUser, $cashierId, true);

                    if ($activeCashDesk) {
                        DB::rollBack();
                        $result['title'] = __('global.warning');
                        $result['body'] = __(self::$slug . '.cashier.cashier-already-in-use');
                        $result['icon'] = 'heroicon-m-check-circle';
                        $result['color'] = 'danger';
                    }

                    //$openingStockCheck = $cashierService->checkStockQuantity($record, 'opening');

                    $cashierRegisterClosure_data = [
                        'user_id' => $currentUser->id,
                        'cashier_id' => $cashierId,
                        'cashier_detail' => "Biglietteria",
                        'date' => date('Y-m-d'),
                        'opened_at' => date('H:i:s'),
                        'opening_cash_amount_last_closure' => $openingCashAmountLastClosure,
                        'opening_cash_amount_registered' => $openingCashAmountRegistered,
                        'opening_notes' => $openingNotes,
                        //'opening_stock_check_passed' => $openingStockCheck->passed,
                        //'opening_stock_check_values' => $openingStockCheck->values,
                    ];

                    $cashierRegisterClosureExists = $cashierService->checkCashierRegisterClosureExists($cashierId, $currentUser->id);

                    $cashier = $cashierService->getWithSite($cashierId);
                    if ($cashierRegisterClosureExists) {
                        DB::rollBack();
                        $result['title'] = __('global.warning');
                        $result['body'] = __(self::$slug . '.cashier.cashier-already-open');
                        $result['icon'] = 'heroicon-m-check-circle';
                        $result['color'] = 'danger';
                    }else{
                        $cashierService->createCashierRegisterClosure($cashierRegisterClosure_data);
                        $cashierService->setCurrentCashierSession($site->id, $cashierId);

                        $result['title'] = __(self::$slug . '.cashier.successful-opening');
                        $result['icon'] = 'heroicon-m-x-circle';
                        $result['body'] = __(self::$slug . '.cashier.successful-opening-desc');
                        $result['color'] = 'success';
                    }

                } catch (\Exception $e) {
                    DB::rollBack();
                    $result['title'] = __('global.warning');
                    $result['icon'] = 'heroicon-m-check-circle';
                    $result['body'] = $e->getMessage();
                    //$result['body'] = $e->getMessage()." ".$e->getLine()." ".$e->getFile()
                    $result['color'] = 'danger';
                }
                $notification = new NotificationService;
                $notification->getNotification($result);
            })
            ->disabled(function(){
                $orderService = new OrderService;
                $cashierService = new CashierService;
                $site_id = request('site_id') ? request('site_id') : session('site_id');
                $currentUser = $orderService->getCurrentUser($site_id);
                return ($cashierService->hasAnotherOpenDesk($currentUser->id)) ?  true :  false ;
            })
            ->hidden(function(){
                $orderService = new OrderService;
                $cashierService = new CashierService;
                $site_id = request('site_id') ? request('site_id') : session('site_id');
                $currentUser = $orderService->getCurrentUser($site_id);
                return ($cashierService->hasOpenDesk($currentUser->id, $site_id)) ?  true :  false ;
            }),

            // chiusura cassa
            Actions\Action::make('closeCashier')
            ->label(function (){

                $site_id = request('site_id') ? request('site_id') : session('site_id');
                $cashierService = new CashierService;
                $cashier_id = $cashierService->getCurrentCashierSession($site_id);
                $cashier = Cashier::find($cashier_id);
                $cashier_in_use = (!$cashier) ?  '' : " <br> (<b>". $cashier->name."</b>)";
                return new HtmlString(__(self::$slug.'.cashier.cashier-closing').$cashier_in_use);
            })
            ->form([

                Section::make('POS')
                ->extraAttributes(['style' => 'background-color: #FFDAB9; border-radius:10px;'])
                ->schema([

                    TextInput::make('closure_pos_amount_calculated')
                    ->label(__(self::$slug . '.cashier.closure-pos-amount-calculated'))
                    ->numeric()
                    ->inputMode('decimal')
                    ->readonly()
                    ->suffixIcon('heroicon-o-currency-euro')
                    ->default(function() use ($cashierRegisterClosure) {
                        if (isset($cashierRegisterClosure["currentCashClosurePayments"]["credit_card"])) {
                            return $cashierRegisterClosure["currentCashClosurePayments"]["credit_card"];
                        } else {
                            return "0.00";
                        }
                    })
                    ->columnSpan(1),

                    TextInput::make('closure_pos_amount_registered')
                    ->label(__(self::$slug . '.cashier.closure-pos-amount-registered'))
                    ->live(onBlur: true)
                    ->numeric()
                    ->default('0.00')
                    ->inputMode('decimal')
                    ->suffixIcon('heroicon-o-currency-euro')
                    ->prefixIcon(function(Get $get, $state){
                        if($get('closure_pos_amount_calculated') == $state){
                            return 'heroicon-m-check-circle';
                        }else{
                            return 'heroicon-m-x-circle';
                        }

                    })
                    ->prefixIconColor(function(Get $get, $state){
                        if($get('closure_pos_amount_calculated') == $state){
                            return 'success';
                        }else{
                            return 'danger';
                        }

                    })
                    ->columnSpan(1),

                    FileUpload::make('closure_pos_amount_receipt')
                    ->image()
                    ->imageEditor()
                    ->label('')
                    ->disk(function(){
                        $fileService = new FileService;
                        return $fileService->getStorageDisk();
                    })
                    ->visibility('private')
                    ->directory('/chiusure-cassa/ricevute/'.$site_id.'/'.date('Y').'/'.date('m'))
                    ->columnSpan(1)
                ])->columns(3),

                Section::make('VOUCHER')
                ->extraAttributes(['style' => 'background-color: #ADD8E6; border-radius:10px;'])
                ->schema([

                    TextInput::make('closure_voucher_amount_calculated')
                    ->label(__(self::$slug . '.cashier.closure-voucher-amount-calculated'))
                    ->numeric()
                    ->inputMode('decimal')
                    ->readonly()
                    ->suffixIcon('heroicon-o-currency-euro')
                    ->default(function() use ($cashierRegisterClosure) {
                        if (isset($cashierRegisterClosure["currentCashClosurePayments"]["voucher"])) {
                            return $cashierRegisterClosure["currentCashClosurePayments"]["voucher"];
                        } else {
                            return "0.00";
                        }
                    })
                    ->columnSpan(1),

                    TextInput::make('closure_voucher_amount_registered')
                    ->label(__(self::$slug . '.cashier.closure-voucher-amount-registered'))
                    ->live(onBlur: true)
                    ->default('0.00')
                    ->numeric()
                    ->inputMode('decimal')
                    ->suffixIcon('heroicon-o-currency-euro')
                    ->prefixIcon(function(Get $get, $state){
                        return ($get('closure_voucher_amount_calculated') == $state) ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle';
                    })
                    ->prefixIconColor(function(Get $get, $state){
                        return ($get('closure_voucher_amount_calculated') == $state) ? 'success' : 'danger';
                    })
                    ->columnSpan(1)
                ])->columns(3),

                Section::make('CONTANTI')
                ->extraAttributes(['style' => 'background-color: #FFE4E1; border-radius:10px;'])
                ->schema([

                    TextInput::make('closure_cash_amount_calculated')
                    ->label(__(self::$slug . '.cashier.closure-cash-amount-calculated'))
                    ->numeric()
                    ->inputMode('decimal')
                    ->readonly()
                    ->suffixIcon('heroicon-o-currency-euro')
                    ->default(function() use ($cashierRegisterClosure) {
                        if (isset($cashierRegisterClosure["currentCashClosurePayments"]["cash"])) {
                            return $cashierRegisterClosure["currentCashClosurePayments"]["cash"];
                        } else {
                            return "0.00";
                        }
                    })
                    ->columnSpan(1),


                    TextInput::make('opening_cash_amount_registered')
                    ->label(__(self::$slug . '.cashier.tot-cash-opening'))
                    ->numeric()
                    ->inputMode('decimal')
                    ->readonly()
                    ->suffixIcon('heroicon-o-currency-euro')
                    ->default(function() use ($cashierRegisterClosure) {
                        if (isset($cashierRegisterClosure["openingCashAmountRegistered"])) {
                            return $cashierRegisterClosure["openingCashAmountRegistered"];
                        } else {
                            return "0.00";
                        }
                    })
                    ->columnSpan(1),

                    Hidden::make('site_id')->default($site_id)->columnSpan(1),


                    TextInput::make('closure_hand_amount_registered')
                    ->label(__(self::$slug . '.cashier.closure-hand-amount-registered'))
                    ->live(onBlur: true)
                    ->default('0.00')
                    ->numeric()
                    ->inputMode('decimal')
                    ->suffixIcon('heroicon-o-currency-euro')
                    ->columnSpan(1)
                    ->afterStateUpdated(function(Set $set, Get $get, $state){
                        $paid_amount_registered = empty($get('closure_paid_amount_registered')) ? 0.00 : $get('closure_paid_amount_registered');
                        $cash_amount_calculated = empty($get('closure_cash_amount_calculated')) ? 0.00 : $get('closure_cash_amount_calculated');
                        $hand_amount_registered = empty($get('closure_hand_amount_registered')) ? 0.00 : $get('closure_hand_amount_registered');
                        $opening_cash_amount_registered = empty($get('opening_cash_amount_registered')) ? 0.00 : $get('opening_cash_amount_registered');

                        $set('closure_cash_amount_partial', number_format($opening_cash_amount_registered + ($cash_amount_calculated - $paid_amount_registered - $hand_amount_registered), 2,'.',''));
                    }),

                    Select::make('closure_hand_amount_to')
                    ->requiredUnless('closure_hand_amount_registered', '0')
                    ->label(__(self::$slug . '.cashier.cash-to'))
                    ->options($listCashUsers)
                    ->preload(),

                    FileUpload::make('closure_hand_amount_receipt')
                    ->image()
                    ->imageEditor()
                    ->label('')
                    ->disk(function(){
                        $fileService = new FileService;
                        return $fileService->getStorageDisk();
                    })
                    ->visibility('private')
                    ->directory('/chiusure-cassa/ricevute/'.$site_id.'/'.date('Y').'/'.date('m'))
                    ->columnSpan(1),

                    TextInput::make('closure_paid_amount_registered')
                    ->label(__(self::$slug . '.cashier.closure-paid-amount-registered'))
                    ->live(onBlur: true)
                    ->default('0.00')
                    ->numeric()
                    ->inputMode('decimal')
                    ->suffixIcon('heroicon-o-currency-euro')
                    ->columnSpan(1)
                    ->afterStateUpdated(function(Set $set, Get $get, $state){
                        $paid_amount_registered = empty($get('closure_paid_amount_registered')) ? 0.00 : $get('closure_paid_amount_registered');
                        $cash_amount_calculated = empty($get('closure_cash_amount_calculated')) ? 0.00 : $get('closure_cash_amount_calculated');
                        $hand_amount_registered = empty($get('closure_hand_amount_registered')) ? 0.00 : $get('closure_hand_amount_registered');
                        $opening_cash_amount_registered = empty($get('opening_cash_amount_registered')) ? 0.00 : $get('opening_cash_amount_registered');

                        $set('closure_cash_amount_partial', number_format($opening_cash_amount_registered + ($cash_amount_calculated - $paid_amount_registered - $hand_amount_registered), 2,'.',''));
                    }),

                    Select::make('safe_id')
                        ->requiredUnless('closure_paid_amount_registered', '0')
                        ->label(__(self::$slug . '.cashier.safe'))
                        ->options(Safe::where('site_id', $site_id)->pluck('name', 'id')),


                    FileUpload::make('closure_paid_amount_receipt')
                        ->image()
                        ->imageEditor()
                        ->label('')
                        ->disk(function(){
                            $fileService = new FileService;
                            return $fileService->getStorageDisk();
                        })
                        ->visibility('private')
                        ->directory('/chiusure-cassa/ricevute/'.$site_id.'/'.date('Y').'/'.date('m'))
                        ->columnSpan(1),


                    TextInput::make('closure_cash_amount_partial')
                    ->label(__(self::$slug . '.cashier.closure-cash-amount-partial'))
                    ->numeric()
                    ->inputMode('decimal')
                    ->readonly()
                    ->suffixIcon('heroicon-o-currency-euro')
                    ->columnSpan(1)
                    ->default(function(Set $set, Get $get, $state){
                        $paid_amount_registered = empty($get('closure_paid_amount_registered')) ? 0.00 : $get('closure_paid_amount_registered');
                        $cash_amount_calculated = empty($get('closure_cash_amount_calculated')) ? 0.00 : $get('closure_cash_amount_calculated');
                        $hand_amount_registered = empty($get('closure_hand_amount_registered')) ? 0.00 : $get('closure_hand_amount_registered');
                        $opening_cash_amount_registered = empty($get('opening_cash_amount_registered')) ? 0.00 : $get('opening_cash_amount_registered');

                        return number_format($opening_cash_amount_registered + ($cash_amount_calculated - $paid_amount_registered - $hand_amount_registered), 2,'.','');
                    }),

                    TextInput::make('closure_cash_amount_registered')
                    ->label(__(self::$slug . '.cashier.closure-cash-amount-registered'))
                    ->live(onBlur: true)
                    ->numeric()
                    ->default('0.00')
                    ->inputMode('decimal')
                    ->suffixIcon('heroicon-o-currency-euro')
                    ->prefixIcon(function(Get $get, $state){
                        if($get('closure_cash_amount_partial') == $state){
                            return 'heroicon-m-check-circle';
                        }else{
                            return 'heroicon-m-x-circle';
                        }

                    })
                    ->prefixIconColor(function(Get $get, $state){
                        if($get('closure_cash_amount_partial') == $state){
                            return 'success';
                        }else{
                            return 'danger';
                        }

                    }),

                    Placeholder::make('Controllo contanti')->hiddenLabel()
                    ->content(new HtmlString(__(self::$slug . '.cashier.alert-check-cash')))

                ])->columns(3),

                Textarea::make('closure_notes')
                ->label(__('global.notes'))

            ])
            ->action(function (array $data): void {

                $status = 'error';
                $status = 'danger';
                $title = '';
                $message = '';
                $errors = null;

                try {
                    $cashierService = new CashierService;
                    $cashier = $cashierService->getOpenCashier($data['site_id'])->cashier;
                    $site_id = request('site_id') ? request('site_id') : session('site_id');
                    $orderService = new OrderService;
                    $user = $orderService->getCurrentUser($site_id);
                    $userId = $user->id;

                    if (!$cashier) {
                        throw new \Exception(__(self::$slug.'.cashier.no-open-cashier-for').'<b>' . $user->fullname . '</b>');
                    }

                    $currentCashClosure = CashierRegisterClosure::where('cashier_id', '=', $cashier->id)
                        ->whereNull('closed_at')
                        ->orderBy('date', 'desc')
                        ->first();

                    if (!$currentCashClosure) {
                        throw new \Exception(__(self::$slug.'.cashier.closure-error'));
                    }

                        if($data['closure_paid_amount_registered'] > 0){
                            $operationData = [
                                'safe_id' => $data['safe_id'],
                                'operation_date' => now(),
                                'user_id' => auth()->user()->id,
                                'first_name' => auth()->user()->first_name,
                                'last_name' => auth()->user()->last_name,
                                'company' => 'Aditus',
                                'amount' => $data['closure_paid_amount_registered']
                            ];
                            SafeOperation::insert($operationData);
                        }
                        $response = $cashierService->saveOnsiteClosure($currentCashClosure->id, $data, 'closed', $user);

                        $status = $response->status;
                        $title = $response->title;
                        $message = $response->message;
                        $color = $response->color;
                        $icon = $response->icon;
                    //}
                } catch (\Exception $e) {
                    $status = 'error';
                    $title = 'Attenzione!';
                    $color = 'danger';
                    $icon = 'heroicon-m-x-circle';
                    $message = $e->getMessage();
                    //$message = $e->getMessage()." ".$e->getLine()." ".$e->getFile()
                }

                $responseJson = [
                    'status' => $status,
                    'title' => $title,
                    'body' => $message,
                    'color' => $color,
                    'icon' => $icon,
                    'errors' => $errors
                ];

                $notification = new NotificationService;
                $notification->getNotification($responseJson);
            })
            ->hidden(function(){

                $orderService = new OrderService;
                $cashierService = new CashierService;
                $site_id = request('site_id') ? request('site_id') : session('site_id');
                $currentUser = $orderService->getCurrentUser($site_id);

                return ($cashierService->hasOpenDesk($currentUser->id, $site_id)) ?  false :  true ;
            }),

        ];
    }


    protected function getFooterWidgets(): array
    {
        $cashierService = new CashierService;
        return [
            OrdersList::make([
                'cashier_id' => $cashierService->getCurrentCashierSession(request('site_id')),
            ]),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        $categories = ProductCategory::select('slug')->get()->toArray();
        return [
            InsertProduct::make([
                'site_id' => request('site_id'),
                'categories' => $categories,
            ]),
            ModalPrint::class,
            CartWidget::make(),
            Slots::class,
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['reduction_fields'] = [];
        $data['names_data'] = [];

        foreach ($data as $key => $value) {
            if (strpos($key, 'reduction_fields') === 0 && !empty($value)) {
                $newKey = str_replace('reduction_fields', '', $key);

                preg_match('/\[(\d+)\]\[fields\]\[(\d+)\]\[product\]\[(\d+)\]\[reduction\]\[(\d+)\]/', $newKey, $matches);

                if (count($matches) === 5) {
                    $index = $matches[1];
                    $reductionFieldId = $matches[2];
                    $productId = $matches[3];
                    $reductionId = $matches[4];

                    $data['reduction_fields'][$productId][$index][$reductionFieldId] = [
                        'reduction_id' => $reductionId,
                        'value' => $value,
                    ];
                }
            }
        }

        foreach ($data as $key => $value) {
            if (strpos($key, 'reduction_fields') === 0 && !empty($value)) {
                $newKey = str_replace('reduction_fields', '', $key);

                preg_match('/\[(\d+)\]\[fields\]\[(\d+)\]\[product\]\[(\d+)\]\[reduction\]\[(\d+)\]/', $newKey, $matches);

                if (count($matches) === 5) {
                    $index = $matches[1];
                    $reductionFieldId = $matches[2];
                    $productId = $matches[3];
                    $reductionId = $matches[4];

                    $data['reduction_fields'][$productId][$index][$reductionFieldId] = [
                        'reduction_id' => $reductionId,
                        'value' => $value,
                    ];
                }
            } elseif (strpos($key, 'names_data') === 0 && !empty($value)) {
                $newKey = str_replace('names_data', '', $key);

                preg_match('/\[(\d+)\]\[fields\]\[(\-\d+)\]\[product\]\[(\d+)\]\[reduction\]\[(first_name|last_name)\]/', $newKey, $matches);

                if (count($matches) === 5) {
                    $index = $matches[1];
                    $fieldId = $matches[2];
                    $productId = $matches[3];
                    $nameField = $matches[4];

                    $data['names_data'][$productId][$index][$nameField] = $value;
                }
            }
        }

        $orderService = new OrderService;
        $site_id = request('site_id') ? request('site_id') : session('site_id');
        $currentUser = $orderService->getCurrentUser($site_id);
        $data['user_id'] = $currentUser->id;

        $orderStatusService = new OrderStatusService;
        $completedStatusId = $orderStatusService->getCompletedStatusId();
        $data['order_status_id'] = $completedStatusId;

        $cashierService = new CashierService;
        $cashier_id = $cashierService->getCurrentCashierSession($site_id);
        $data['cashier_id'] = $cashier_id;
        $data['company_id'] = 1;
        $data['order_type_id'] = OrderType::where('slug', 'onsite')->first()->id;

        $type = OrderType::where('slug', 'onsite')->first();
        $data['prefix'] = $type->prefix;
        $orderService = new OrderService();
        $res_prog = $orderService->getProgressive($type->prefix);

        $data['progressive'] = ($res_prog == null) ? '1' : $res_prog + 1;

        $data['year'] = date('Y');
        $data['order_number'] = $data['prefix']."-".$data['year']."-".str_pad($data['progressive'], 8, '0', STR_PAD_LEFT)."-".$data['cashier_id'];

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        DB::beginTransaction();
        try {
            $productService = new ProductService(new Product);
            $orderService = new OrderService;
            $currentUser = auth()->user();
            $products = $productService->getCartProducts($currentUser->id, $data['site_id']);

            if ($products->isEmpty()) {
                throw new \Exception(__(self::$slug . '.no-products-selected'));
            }

            $record = $orderService->create($data);
            $record->site_id = $data['site_id'];
            $tot_price = 0;

            foreach ($products as $product) {
                $productService = new ProductService($product);
                $tot_price += $product->price_sale * $product->qty;
                if ($product->open_ticket) {
                    $product->date_service = null;
                    $product->hour_service = null;
                }

                $orderItemService = new OrderItemService();
                $orderItemService->checkDateAndHour($product);

                $order_item = $orderItemService->create($product, $record);
                $cartProductService = new CartProductService();
                $cartProductService->emptyByCartId($product->cart_id);

                $cartService = new CartService();
                $cartService->empty($product->cart_id);

                if ($data['names_data']) {
                    $orderService->insertHolders($data['names_data'], $order_item->id, $product->id);
                }elseif ($product->is_name == 1) {
                    throw new \Exception(__(self::$slug . '.no-name-data-filled'));
                }

                if ($data['reduction_fields']) {

                    $orderService->insertRequiredFields($data['reduction_fields'], $order_item->id, $product->id);
                }elseif ($product->check_document == 1) {
                    throw new \Exception(__(self::$slug . '.no-reduction-fields-filled'));
                }

            }

            $orderService->orderCheckMatrix($record, 'onsite');

            if($product->service->product_category->slug == 'site-events'){
                foreach ($record->items as $item) {
                    $siaeService = new SiaeService();
                    $res_ticket = $siaeService->emettiBiglietto(SiaeOrderItem::find($item->id));
                    if($res_ticket === false){
                        throw new \Exception(__('global.warning'));
                    }elseif($res_ticket === -1){
                        throw new \Exception(__(self::$slug . '.no-free-spots'));
                    }
                }
            }
            foreach ($products as $product) {
                foreach($product->related_products AS $rel_prod){
                    $tot_price += $rel_prod->price_sale * $product->qty;
                    $rel_prod->qty = $product->qty;
                    $rel_prod->total = $product->total;
                    $order_item = $orderItemService->insertRelated($rel_prod, $record);
                }
            }
            $paymentService = new PaymentService();
            $payment_record = $paymentService->create($data['payment_type_id'], $tot_price);

            $orderService->updateAfterPayment($record->id, $payment_record);
            $orderItemService->updateByOrderId($record->id, ['payment_id' => $payment_record->id]);

            $this->dispatch('open_print', order_id : $record->id);
            $result = [
                'error' => 0,
                'color' => 'success',
                'title' => __("global.save-successful"),
                'body' => '',
                'icon' => 'heroicon-m-check-circle'
            ];

            DB::commit();
            $notification = new NotificationService;
            $notification->getNotification($result);
        } catch (\Exception $e) {
            $record = new SiaeOrder();
            $record->site_id = $data['site_id'];
            DB::rollBack();
            $result = [
                'error' => 1,
                'title' => __('global.warning'),
                'color' => 'danger',
                'icon' => 'heroicon-m-x-circle',
                //'body' => $e->getMessage()
                'body' => $e->getMessage()." ".$e->getLine()." ".$e->getFile()
            ];
            $notification = new NotificationService;
            $notification->getNotification($result);
            $this->halt();
        }

        return $record;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }
}




?>
