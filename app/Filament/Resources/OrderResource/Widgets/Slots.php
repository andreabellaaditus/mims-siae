<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use Filament\Widgets\Widget;
use Forms\Concerns\InteractsWithForms;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Livewire\Component;
use App\Models\Cart;
use App\Models\SiaeScan;
use App\Models\SiaeScanLog;
use App\Models\DocumentType;
use App\Models\Product;
use App\Models\CartProduct;
use App\Models\Order;
use App\Models\ReductionField;
use App\Models\Service;
use App\Models\Slot;
use Filament\Forms\Components\View;
use App\Filament\Resources\OrderResource\Pages\CreateOrder;
use App\Models\Scopes\ActiveScope;
use Illuminate\Contracts\Session\Session;
use Carbon\Carbon;
use App\Services\ProductService;
use App\Services\OrderService;
use App\Services\ScanService;
use App\Services\CartProductService;
use App\Services\CartService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;

class Slots extends Widget
{
    protected $listeners = ['refresh_dates' => 'mount', 'scan'];
    protected static string $view = 'filament.resources.order-resource.widgets.slots';
    protected int | string | array $columnSpan = 'full';

    //protected static ?string $model = Cart::class;
    public $products = array();
    public $document_types = array();

    public $formData = [];
    public $array_red = [];
    public $array_namesdata = [];
    public $selectedDate;
    public string $qr_code;

    /*public function inputValueChanged($values)
    {
        foreach ($values as $key => $value) {
            $parts = explode(".", $key);

            $indice = $parts[1];
            $field_id = $parts[3];
            $product_id = $parts[5];
            $reduction_id = $parts[count($parts) - 1];

            if($field_id > 0){
                $this->array_red[$product_id][$indice][$field_id]['value'] = $value;
                $this->array_red[$product_id][$indice][$field_id]['reduction_id'] = $reduction_id;
            }else{
                $this->array_namesdata[$product_id][$indice][$reduction_id] = $value;
            }
        }
        session()->put('reduction_fields', $this->array_red);
        session()->put('names_data', $this->array_namesdata);
    }*/

    public function mount()
    {
        $cartService = new CartService;
        $orderService = new OrderService;

        $site_id = session('site_id');
        $currentUser = auth()->user();
        $cart = $cartService->getCart($currentUser->id);
        $this->products = array();
        $this->document_types = DocumentType::all();
        if ($cart){
            $cartProductService = new CartProductService;
            $this->products = $cartProductService->getGroupedSlots($cart, $site_id);
        }
        $this->dispatch('refresh_reduction_fields');
    }

    protected function getFormModel(): string
    {
        return Cart::class;
    }

    public function updateDateService($product_id, $date_service)
    {
        $data = ['date_service' => $date_service];
        $cartProductService = new CartProductService();
        $cartProductService->updateByProduct($product_id, $data);
        $this->dispatch('refresh_dates');
    }

    public function hideOrShowDate($product_id, $open_ticket)
    {
        $data = ['open_ticket' => $open_ticket];
        $cartProductService = new CartProductService();
        $cartProductService->updateByProduct($product_id, $data);
        $this->dispatch('refresh_dates');
    }

    public function updateHourService($product_id, $hour_service)
    {
        $data = ['hour_service' => $hour_service];
        $cartProductService = new CartProductService();
        $cartProductService->updateByProduct($product_id, $data);
        $this->dispatch('refresh_dates');
    }

    public function scan($qr_code){
        $scanService = new ScanService;
        $err_slot = 0;
        $site_id = session('site_id');

        $result = [
            'error' => 1,
            'title' => __('global.warning'),
            'color' => 'danger',
            'icon' => 'heroicon-m-x-circle',
            'body' => ''
        ];
        $logData = [
            'qr_code' => $qr_code,
            'site_id' => $site_id,
            'status' => 'error',
            'response' => '',
            'product_id' => 0
        ];

        if(isset($qr_code)){
            if(strlen($qr_code) == 16){
                $scanInfo = $scanService->getScanInfo($qr_code);
                $product_id = $scanInfo->product_id;
                $is_card = $scanInfo->product->is_card;
                $service_id = $scanInfo->product->service_id;
                $is_cumulative = $scanInfo->product->is_cumulative;
                $cumulative_ticket = $scanInfo->is_cumulative;
                $prod_cat = $scanInfo->product->service->product_category->name;
                $date_service = $scanInfo->date_service;
                $hour_service = $scanInfo->hour_service;
                $date_expiration = $scanInfo->date_expiration;
                $max_scans = $scanInfo->product->max_scans;
                $ticket_site_id = $scanInfo->product->service->site_id;
                $order_item_id = $scanInfo->id;
                $product = $scanInfo->product;
                $scanInfo->qr_code = $qr_code;
                $site_id = session('site_id');
                // se è cumulativo creo array di siti
                if($scanInfo->product->sites){
                    foreach($scanInfo->product->sites as $site){
                        $site_ids[] = $site->id;
                    }
                }

                if((!$is_cumulative && $ticket_site_id == $site_id) ||
                    ($is_cumulative && in_array($site_id, $site_ids))){
                    if($scanInfo->count() > 0){
                        $rescheck = $scanService->checkScans($scanInfo, $site_id, $qr_code);
                        if($rescheck['error'] == 0){
                            DB::beginTransaction();
                            try{
                                if($date_expiration >= date('Y-m-d H:i:s')){
                                    if($date_service != null){
                                        if($date_service == date('Y-m-d')){
                                            if($hour_service != null){

                                                $weekday_order = strtolower(date('D', strtotime($date_service)));

                                                $slot = $scanService->getHour($weekday_order, 'product_id', $product_id);
                                                if(!$slot){
                                                    $slot = $scanService->getHour($weekday_order, 'service_id', $service_id);
                                                }

                                                $hour_service_min = Carbon::parse($hour_service)->subMinutes($slot->advance_tolerance)->format("H:i:s");
                                                $hour_service_max = Carbon::parse($hour_service)->addMinutes($slot->delay_tolerance)->format("H:i:s");
                                                if($hour_service_min > date('H:i:s') || $hour_service_max < date('H:i:s')){
                                                    $err_slot = 1;
                                                    // se l'orario non coincide con lo slot
                                                    $result['body'] = __('orders.scan.wrong-hour');
                                                }
                                            }
                                        }else{
                                            $err_slot = 1;
                                            // se la data del biglietto è diversa da quella di oggi
                                            $result['body'] = __('orders.scan.wrong-date');
                                        }
                                    }
                                    if($err_slot == 0){
                                        $esitoScan = $scanService->scan($qr_code, $cumulative_ticket, $order_item_id, $product, $scanInfo);

                                        if($esitoScan){
                                            $logData['status'] = 'success';
                                            $logData['response'] = 'success';
                                            $result = [
                                                'error' => 0,
                                                'title' => __('orders.scan.success-title'),
                                                'color' => 'success',
                                                'icon' => 'heroicon-m-check-circle',
                                                'body' => __('orders.scan.success-desc'),
                                            ];
                                        }else{
                                            $result['body'] = $esitoScan;
                                        }
                                    }
                                }else{
                                    // se il biglietto è scaduto
                                    $result['body'] = __('orders.scan.ticket-expired');
                                }

                            } catch (\Exception $e) {
                                DB::rollBack();
                                $result = [
                                    'error' => 1,
                                    'title' => __('global.warning'),
                                    'color' => 'danger',
                                    'icon' => 'heroicon-m-x-circle',
                                    'body' => $e->getMessage()." ".$e->getLine()." ".$e->getFile()
                                ];
                                $notification = new NotificationService;
                                $notification->getNotification($result);
                            }
                        }else{
                            // se il numero massimo di scansioni è stato raggiunto
                            $result['body'] = $rescheck['message'];
                        }
                    }else{
                        // se il qr code non esiste a sistema
                        $result['body'] = __('orders.scan.code-not-exists');
                    }
                }else{
                    // se il sito del biglietto è errato
                    $result['body'] = __('orders.scan.wrong-site');
                }
            }else{
                // se la lunghezza del qr code è maggiore di 16 caratteri
                $result['body'] = __('orders.scan.wrong-length');
            }
        }else{
            // se il qr code non è valido
            $result['body'] = __('orders.scan.code-not-valid');
        }

        $logData['response'] = $result['body'];
        $logData['product_id'] = $product_id;
        SiaeScanLog::create($logData);
        DB::commit();
        $notification = new NotificationService;
        $notification->getNotification($result);
    }
}
