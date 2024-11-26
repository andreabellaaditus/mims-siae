<?php

namespace App\Http\Controllers;

use App\Models\{ User, PaymentType, Product, ProductReductionField, SiaeScan, Cart, Company, DocumentType, SiaeOrder, SiaeOrderItem, SiaeOrderItemReduction, OrderItemStatus, OrderStatus, OrderType, Payment, SiaeProductHolder, SiaeOrderReprint};
use App\Http\Controllers\Controller;
use App\Http\Helpers\{Ecommerce, Functions, ProductFeeHelper, Stripe, StripeSca };
use App\Http\Requests\storeOrderRequest;
use App\Jobs\DeleteCart;
use App\Jobs\SendOrderEmail;
use App\Services\MatrixService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\SiaeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\{ DB, Mail };
use Illuminate\Support\Facades\Response;
use PDF;
use Stripe\Exception\ApiErrorException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private StripeClient $stripe;
    /*public function __construct()
    {
        $this->middleware('logged-user')->except('endpayment', 'store', 'createStripePrices', 'finishOrder', 'history');
    }*/

    public function store(storeOrderRequest $request)
    {
        $user = request()->input('user');
        $user = User::where('email', $user['email'])->first();
        auth()->setUser($user);
        $payment_link = null;
        $order = null;

        try {
            DB::transaction(function () use (&$order, &$payment_link, $request) {
                $lang = "it";
                if ($request->lang !== null) {
                    $lang = $request->lang;
                }
                $cart = Cart::with([
                        'cart_products.product' => function($product) {
                            $product->select('id', 'name', 'service_id', 'date_event', 'price_sale', 'price_web', 'validity_from_issue_unit', 'validity_from_issue_value', 'has_additional_code', 'is_siae', 'code', 'cod_ordine_posto')
                                ->with([
                                    'service' => function($service) {
                                        $service->select('id', 'name', 'is_pending', 'product_category_id');
                                    },
                                ]);
                        }
                    ])
                    ->where('user_id', auth()->user()->id)
                    ->first();

                $siaeService = new SiaeService();

                if(isset($cart->cart_products)){
                    foreach ($cart->cart_products as $cartProduct) {
                        if ($cartProduct->product->is_siae) {
                            if ($siaeService->getDisponibilitaOrdinePosto($cartProduct->product->code, $cartProduct->product->cod_ordine_posto) <= 0) {
                                if ($order) {
                                    $cancelledStatus = OrderStatus::where('slug', 'deleted')->first();
                                    $order->deleted_at = Carbon::now();
                                    $order->order_status_id = $cancelledStatus->id;
                                }
                                throw new HttpResponseException(
                                    response()->json([
                                        'success' => false,
                                        'status' => 'error',
                                        'message' => 'Posti esauriti per ' . $cartProduct->product->name . " - " . $cartProduct->product->date_event
                                    ])
                                );
                            }

                            $eventDateTime = Carbon::parse($cartProduct->product->date_event);
                            if ($eventDateTime->isPast()) {
                                if ($order) {
                                    $cancelledStatus = OrderStatus::where('slug', 'deleted')->first();
                                    $order->deleted_at = Carbon::now();
                                    $order->order_status_id = $cancelledStatus->id;
                                }
                                throw new HttpResponseException(
                                    response()->json([
                                        'success' => false,
                                        'status' => 'error',
                                        'message' => 'L\'evento selezionato '.$cartProduct->product->service->name.' è già avvenuto in data '. $eventDateTime->format('d-m-Y H:i:s')
                                    ])
                                );
                            }
                        }
                    }
                }

                if(isset($cart->cart_products)){
                    $order = $this->storeOrder($cart, auth()->user());
                    $orderItems = $this->storeOrderItems($cart, $order);
                    //$this->storeReductions($orderItems);
                    //$this->storeProductHolders($orderItems, $cart);

                    //$orderService = new OrderService();
                    //$orderService->order_check_matrix_online($order->id);
                    //$payment = $this->createStripePayment($order, $lang);
                    //$payment_link = $payment->url . "?prefilled_email=" . auth()->user()->email;

                }
            });
        } catch (Throwable | ApiErrorException $e) {
            $user = auth()->user();
            if ($order) {
                $cancelledStatus = OrderStatus::where('slug', 'deleted')->first();
                $order->deleted_at = date('Y-m-d H:i:s');
                $order->order_status_id = $cancelledStatus->id;
            }

            $this->notifyError($e, $user);
            $error = $e->getMessage();
            $order = null;
        }

        return collect([
            'success' => !isset($error),
            'status' => $error ?? 'success',
            'data' => isset($order) ? $this->getOrderResource($order, $payment_link) : false
        ]);
    }

    public function storia(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        try {
            $orders = SiaeOrder::where('user_id', $user->id)->limit(5)->get();
        }
        catch(Throwable $e) {
            $error = $e->getMessage();
        }

        return collect([
            'success' => !isset($error),
            'status' => $error ?? 'success',
            'data' => isset($orders) ? $this->getOrdersResource($orders) : false
        ]);
    }

    public function tickets($orderId)
    {
        $order = Functions::getFullOrderInformations($orderId);
        $purchasedItems = $order
            ->items
            ->each(function($item) {
                $item->whereHas('order_item_status', function($orderItemStatus) {
                    $orderItemStatus->where('slug','purchased');
                });
            });
        $ticketPdf = PDF::loadView('online.tickets.confirmed-ticket', ['order' => $order, 'items' => $purchasedItems]);

        return $ticketPdf->download('tickets.pdf');
    }

    private function getOrdersResource($orders)
    {
        $ordersResource = [];
        $orders
            ->each(function($order) use (&$ordersResource) {
                $ordersResource[] = $this->getOrderResource($order);
            });

        return $ordersResource;
    }

    private function storeOrder(Cart $cart, $user)
    {
        $type = OrderType::select('id', 'prefix')
            ->where('slug', 'online')
            ->firstOrFail();
        $orderService = new OrderService();
        $progressive = OrderService::getProgressive($type->prefix);
        $orderNumber = OrderService::getOrderNumber($type->prefix, $progressive);

        $payment = Payment::select('id')
            ->where('code', 'not_payed')
            ->firstOrFail();

        $status = OrderStatus::select('id')
            ->where('slug', 'pending')
            ->firstOrFail();

        $orderTotalPrice = $cart->getConfirmedTotal($cart);

        return SiaeOrder::create([
            'order_number' => $orderNumber,
            'prefix' => $type->prefix,
            'progressive' => $progressive,
            'year' => date('Y'),
            'company_id' => 1,
            'user_id' => $user->id,
            'order_type_id' => $type->id,
            'order_status_id' => $status->id,
            'payment_id' => $payment->id,
            'price' => $orderTotalPrice,
            //'bollo' => OrderService::bolloIsNeeded($orderTotalPrice) && $user->client->role->code == 'travel-agency' ? 2 : 0,
            'notes' => '',
            'qr_code' => Functions::generateQrCodeHash($user->id, $orderNumber),
            'invoice_request' => request('invoice'),
        ]);
    }

    public function storeOrderItems(Cart $cart, SiaeOrder $order)
    {
        $orderItemStatus = OrderItemStatus::select('id', 'slug')
            ->whereIn('slug', ['purchased', 'pending'])
            ->get();

        $orderItems = [];
        $cart->cart_products
            ->groupBy('product_id')
            ->each(function($cartProductsByProduct, $productId) use ($order, $orderItemStatus, &$orderItems) {
                $cartProductsByProduct
                    ->groupBy('date_service')
                    ->each(function($cartProductsByDateService, $dateService) use ($order, $orderItemStatus, &$orderItems) {
                        $cartProductsByDateService
                            ->groupBy('hour_service')
                            ->each(function($cartProductsByHourService, $hourService) use ($order, $orderItemStatus, &$orderItems) {
                                $cartProduct = $cartProductsByHourService->first();
                                $product = $cartProduct->product;
                                $statusCode = $product->service->is_pending ? 'pending' : 'purchased';
                                $qty = $cartProductsByHourService->count();

                                $productService = new ProductService($product);
                                $orderItem = SiaeOrderItem::create([
                                    'siae_order_id' => $order->id,
                                    'product_id' => $product->id,
                                    'order_item_status_id' => $orderItemStatus->where('slug', $statusCode)->first()->id,
                                    'qty' => $qty,
                                    'price' => $qty * $product->price_sale,
                                    'validity' => $productService->getValidity(),
                                    'printable_qr_code' => Functions::generateQrCodeHash($order->id, $product->id . "-1"),
                                    'is_cumulative' => 0,
                                    'date_service' => $cartProduct->date_service,
                                    'hour_service' => $cartProduct->hour_service,
                                    'language_service' => null,
                                    'num_pax_service' => null,
                                    'pickup_service' => null,
                                    'duration_service' => null,
                                    'credit_card_fees' => in_array($product->service->product_category->slug, ['tickets', 'site-events']) ? 0 : Stripe::calculateFees($qty * $product->price_sale),
                                    'product_place_order_id' => null,
                                    'additional_code' => $product->has_additional_code ? SiaeOrderItem::getAdditionalCode() : null
                                ]);

                                foreach($product->related_products AS $rel_prod){
                                    $productService = new ProductService($product);
                                    SiaeOrderItem::create([
                                        'siae_order_id' => $order->id,
                                        'product_id' => $rel_prod->id,
                                        'order_item_status_id' => $orderItemStatus->where('slug', $statusCode)->first()->id,
                                        'qty' => $qty,
                                        'price' => $qty * $rel_prod->price_sale,
                                        'validity' => $productService->getValidity(),
                                        'printable_qr_code' => Functions::generateQrCodeHash($order->id, $rel_prod->id . "-1"),
                                        'is_cumulative' => 0,
                                        'date_service' => $cartProduct->date_service,
                                        'hour_service' => $cartProduct->hour_service,
                                        'language_service' => null,
                                        'num_pax_service' => null,
                                        'pickup_service' => null,
                                        'duration_service' => null,
                                        'credit_card_fees' => in_array($rel_prod->service->product_category->slug, ['tickets', 'site-events']) ? 0 : Stripe::calculateFees($qty * $rel_prod->price_sale),
                                        'product_place_order_id' => null,
                                        'additional_code' => $rel_prod->has_additional_code ? SiaeOrderItem::getAdditionalCode() : null
                                    ]);
                                }

                                self::createOrderItemMatrix('online', $orderItem);


                                $orderItems[] = $orderItem;
                            });
                    });
            });

        return $orderItems;
    }


    static function createOrderItemMatrix($type, $item)
    {
        $defaultPurchaseGroup = MatrixService::getPurchaseGroupByCashierId();
        $arr_scans = [];

        try {
            if ($item->product->service->product_category->slug == "tickets" || $item->product->service->product_category->slug == "site-events") {
                $itemScans = OrderService::getScanInfo($type, $item, $item->product, $defaultPurchaseGroup);
                foreach ($itemScans as $scan){
                    $arr_scans[] = $scan;
                }
            }

            SiaeScan::insert($arr_scans);

        } catch (\Exception $e) {
            throw $e;
        }

    }
    public function storeReductions($orderItems)
    {
        if (!is_null(request('reductions'))) {
            $reductions = collect(request('reductions'));
            $orderItemReductionsToCreate = [];

            collect($orderItems)->each(function ($orderItem) use (&$orderItemReductionsToCreate, &$reductions) {
                $filteredReductions = $reductions->filter(function ($reduction) use ($orderItem) {
                    return $reduction['product_id'] == $orderItem->product_id;
                });

                $filteredReductions->each(function ($reduction) use ($orderItem, &$orderItemReductionsToCreate, &$reductions) {
                    $reductionFields = ProductReductionField::where('product_id', $reduction['product_id'])
                        ->get();

                    foreach ($reductionFields as $field) {
                        if ($reduction['value'] && $field->reduction_field_id == $reduction['reduction_field_id']) {
                            $orderItemReductionsToCreate[] = [
                                'siae_order_item_id' => $orderItem->id,
                                'reduction_id' => $reduction['reduction_id'],
                                'reduction_field_id' => $field->reduction_field_id,
                                'value' => $reduction['value'],
                            ];
                        }
                    }

                    $reductions = $reductions->reject(function ($item) use ($reduction) {
                        return $item === $reduction;
                    });
                });
            });

            SiaeOrderItemReduction::insert($orderItemReductionsToCreate);
        }
    }

    public function createStripePrices(Request $request)
    {
        $order_id = $request->input('order_id');
        $this->stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
        $order = SiaeOrder::find($order_id);
        $array_items = [];
        $totalPrice = 0;

        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            $productName = $product->name;
            $productPrice = $product->price_sale;

            foreach ($product->related_products as $related_prod) {
                $productName .= " + " . $related_prod->name;
                $productPrice += $related_prod->price_sale;
            }

            $price = $this->stripe->prices->create([
                'currency' => 'eur',
                'unit_amount' => $productPrice * 100,
                'product_data' => [
                    'name' => $productName
                ],
                'metadata' => [
                    'site' => $product->service->site->name,
                    'id' => $product->id
                ]
            ]);

            $array_items['line_items'][] = [
                'price' => $price->id,
                'quantity' => $item->qty,
            ];

            $totalPrice += $productPrice * $item->qty; // Moltiplica per la quantità
        }

        return [
            'line_items' => $array_items['line_items'], // Restituisci anche i line_items
            'total_price' => $totalPrice, // Restituisci il totale
        ];
    }


    private function createStripePayment($order, $lang)
    {
        $this->stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
        $array_items = array();
        $array_items['metadata']['order_id'] = $order->id;
        $array_items['metadata']['lang'] = $lang;
        $array_items['metadata']['user_id'] = auth()->user()->id;
        foreach($order->items as $item){

            if (count($item->product->related_products) > 0) {
                foreach ($item->product->related_products as $related_product) {
                    $item->product->name .= " + " . $related_product->name;
                }
            }
        }

        $order->items->each(function($orderItem) use (&$array_items) {
            if($orderItem->product->service->product_category->slug != 'tickets' || ($orderItem->scans && $orderItem->scans->count() > 0)){
                $array_items['line_items'][] = [
                    'price' => $this->createStripePrice($orderItem->product_id),
                    'quantity' => $orderItem->qty,
                ];
            }
        });

        $paymentLink = $this->stripe->paymentLinks->create(
            $array_items);
        return $paymentLink;
    }

    public function endpayment()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
        $event = null;
        try {

            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );

            $order = SiaeOrder::find($event->data->object->metadata->order_id);

        } catch (\UnexpectedValueException $e) {

            $user = auth()->user();
            if (isset($order) && $order) {
                $cancelledStatus = OrderStatus::where('slug', 'deleted')->first();
                $order->deleted_at = date('Y-m-d H:i:s');
                $order->order_status_id = $cancelledStatus->id;
                $order->save();
            }
            if (isset($event->data->object->payment_intent)) {
                $this->refundPayment($stripe, $event->data->object->payment_intent);
            }

            $this->notifyError($e, $user);
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {

            $user = auth()->user();
            if (isset($order) && $order) {
                $cancelledStatus = OrderStatus::where('slug', 'deleted')->first();
                $order->order_status_id = $cancelledStatus->id;
                $order->deleted_at = date('Y-m-d H:i:s');
                $order->save();
            }
            if (isset($event->data->object->payment_intent)) {
                $this->refundPayment($stripe, $event->data->object->payment_intent);
            }

            $this->notifyError($e, $user);
            http_response_code(400);
            exit();
        }

        switch ($event->type) {

            case 'checkout.session.completed':
                $this->finishOrder($order, $order->items, $event->data->object->payment_intent, $event->data->object->metadata->lang, $event->data->object->metadata->user_id);
                break;
            default:
                if (isset($event->data->object->payment_intent)) {
                    $this->refundPayment($stripe, $event->data->object->payment_intent);
                }
                http_response_code(500);
                exit();
        }

        http_response_code(200);
        exit();
    }

    private function refundPayment($stripe, $paymentIntentId)
    {
        try {
            $stripe->refunds->create(['payment_intent' => $paymentIntentId]);
        } catch (\Exception $e) {
            Log::error('Failed to cancel PaymentIntent', ['payment_intent_id' => $paymentIntentId, 'exception' => $e]);
        }
    }


    public function finishOrder(Request $request)
    {
        $order_id = $request->input('order_id');
        $lang = $request->input('lang');
        $email = $request->input('email');
        $user = User::where('email', $email)->firstOrFail();

        $payment_code_id = $request->input('payment_code_id');
        $order = SiaeOrder::find($order_id);
        $orderItems = $order->items;
        $isPending = false;
        $fees = 0;

        collect($orderItems)
            ->each(function($orderItem) use (&$isPending, &$fees, &$lang) {
                if ($orderItem->order_item_status->slug == 'pending') {
                    $isPending = true;
                }

                if($orderItem->product->service->product_category->slug == 'site-events'){

                    $siaeService = new SiaeService();
                    $res_ticket = $siaeService->emettiBigliettoOnline($orderItem, $lang);
                    if($res_ticket === false){
                        throw new \Exception(__('global.warning'));
                    }elseif($res_ticket === -1){
                        throw new \Exception(__('order.no-free-spots'));
                    }

                }

                $fees += $orderItem->credit_card_fees;
            });

        if (!$isPending) {
            $statusCompleted = OrderStatus::select('id')
                ->where('slug', 'completed')
                ->firstOrFail();

            $order->order_status_id = $statusCompleted->id;
        }

        $order->completed_at = Carbon::now()->format('Y-m-d H:i:s');

        $order->payment_id = Payment::insertGetId([
            'gateway' => 'stripe',
            'code' => $payment_code_id ?? 'free',
            'total' => $order->price,
            'payment_type_id' => PaymentType::where('slug', 'stripe')->first()->id
        ]);

        $order->price = $order->price + $fees;
        $order->save();

        $cart = Cart::with('cart_products')->where('user_id', $user->id)->first();

        if ($cart) {
            foreach ($cart->cart_products as $cartProduct) {
                $cartProduct->delete();
            }
            $cart->delete();
        }

        $this->sendTickets($order, $lang);
    }


    public function notifyError($error,$user)
    {
        Mail::send("online.emails.order_online_error",["error" => $error->getMessage()." ".$error->getFile()." ".$error->getLine(), "user" => $user], function ($message) {
            $message->from('info@aditusculture.com', 'Aditus S.r.l.');

            $message->to(env('TEST_EMAIL_RECIPIENT'));
            $message->subject('Errore Creazione Ordine');
        });
    }

    public function sendVoucher()
    {

    }

    public function sendTickets($order, $lang = "it")
    {

        try {
            $order->load([
                'items' => function ($items) {
                    $items->with([
                        'product' => function ($product) {
                            $product->with('service.product_category', 'service.site');
                        },
                        'scans' => function ($scans) {
                            $scans->with('order_item.order_item_reductions', 'virtual_store_matrix');
                        }
                    ]);
                }
            ]);

            $purchasedItems = $order->items->filter(function ($item) {
                return $item->order_item_status()->where('slug', 'purchased')->exists() &&
                       $item->product->service->product_category->slug !== 'site-events';
            });

            if ($purchasedItems->isEmpty()) {
                Log::info('No purchased items to send tickets for order', ['order_id' => $order->id]);
                return;
            }

            foreach ($purchasedItems as $item) {
                $product = $item->product;
                $productName = $product->name;
                $totalPrice = $product->price_sale;

                foreach ($product->related_products as $related_prod) {
                    $productName .= " + " . $related_prod->name;
                    $totalPrice += $related_prod->price_sale;
                }

                $item->product->name = $productName;
                $item->product->price_sale = $totalPrice;
            }

            $ticketPdf = PDF::loadView('online.tickets.confirmed-ticket', [
                'order' => $order,
                'items' => $purchasedItems,
                'currentDomain' => ''
            ]);

            $orderItem = $purchasedItems->first();

            $dateService = $orderItem->date_service ?? Carbon::today()->format('Y-m-d');
            $hourService = $orderItem->hour_service ?? '00:00:00';

            $visitDay = Carbon::createFromFormat('Y-m-d H:i:s', $dateService . ' ' . $hourService);

            Mail::send("online.emails.order.confirmed", [
                'title' => $lang == "en" ? 'GOOD CHOICE' : 'OTTIMA SCELTA!',
                'days' => Carbon::now()->diffInDays($visitDay),
                'hours' => Carbon::now()->diffInHours($visitDay),
                'minutes' => Carbon::now()->diffInMinutes($visitDay),
                'siteName' => $orderItem->product->service->site->name,
                'lang' => $lang
            ], function ($message) use ($order, $ticketPdf, $lang) {
                $message->from('info@aditusculture.com', 'Aditus S.r.l.');
                $message->to($order->user->email);
                $message->subject(($lang == "en" ? "Order Confirmation" : "Conferma Ordine") . " #" . $order->order_number);

                if (env('APP_ENV') == 'production') {
                    $message->bcc("contabilita@aditusculture.com");
                }

                if ($ticketPdf) {
                    $message->attachData($ticketPdf->output(), 'Tickets.pdf', [
                        'mime' => 'application/pdf',
                    ]);
                }
            });

        } catch (\Exception $e) {

            $user = auth()->user();
            $this->notifyError($e, $user);

            Log::error('Error in sendTickets function', [
                'order_id' => $order->id,
                'message' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    private function getOrderResource(SiaeOrder $order, $payment_link = null)
    {
        return [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'total_price' => $order->price,
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
            'items' => $this->getOrderItemsResource($order)
        ];
    }

    private function getOrderItemsResource(SiaeOrder $order)
    {
        $orderItemsResource = [];

        $order->load([
            'items' => function($orderItems) {
                $orderItems->select('id', 'siae_order_id', 'product_id', 'date_service', 'hour_service', 'qty')
                    ->with([
                        'scans',
                        'product' => function($product) {
                            $product->select('id', 'name', 'service_id', 'price_web')
                                    ->with('related_products', 'service', 'service.product_category');
                        }
                    ]);
            }
        ]);

        $order->items->each(function($orderItem) use (&$orderItemsResource) {
            if($orderItem->product->service->product_category->slug != 'tickets' || ($orderItem->scans && $orderItem->scans->count() > 0)){
                $productName = $orderItem->product->name;

                foreach ($orderItem->product->related_products as $related_prod) {
                    $productName .= " + " . $related_prod->name;
                }
                $orderItemsResource[] = [
                    'date_service' => $orderItem->date_service,
                    'hour_service' => $orderItem->hour_service,
                    'product' => $productName,
                    'product_id' => $orderItem->product_id,
                    'id' => $orderItem->id,
                    'price' => $orderItem->product->price_web,
                    'quantity' => $orderItem->qty
                ];
            }
        });
        return $orderItemsResource;
    }


    private function storeProductHolders($orderItems,$cart){
        collect($orderItems)
            ->each(function($orderItem) use ($cart){
                $product = $orderItem->product;
                if ($product->is_name){

                    $cartProducts = $cart->cart_products->filter(function($value) use($orderItem){
                        return $value->product_id == $orderItem->product_id && $value->date_service == $orderItem->date_service && $value->hour_service == $orderItem->hour_service;
                    });

                    $productService = new ProductService($product);
                    foreach($cartProducts as $cartProduct){

                        SiaeProductHolder::create([
                            'product_id' => $orderItem->product_id,
                            'first_name' => $cartProduct->holder_first_name,
                            'last_name' => $cartProduct->holder_last_name,
                            'order_item_id' => $orderItem->id,
                            'expired_at' => $productService->getValidity(),
                        ]);
                    }
                }
            });
    }

}
