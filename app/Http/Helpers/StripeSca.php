<?php

namespace App\Http\Helpers;

use App\Models\SiaeOrder;
use App\Models\SiaeOrderItem;
use App\Payment;
use App\PaymentTransfer;
use App\Product;
use App\ProductSite;
use App\StripePaymentIntent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe as StripeApi;
use Stripe\Customer;
use Stripe\Charge;
use Stripe\Account;
use Stripe\Transfer;
use Stripe\Balance;
use Stripe\BalanceTransaction;

class StripeSca
{

    const TRANSACTION_PERCENTAGE = 0;
    const TRANSACTION_FEE = 0;

    const CODE_POLE_SIRACUSA = 'SR1';
    const CODE_POLE_MESSINA = 'ME3';
    const CODE_ADITUS = 'ADITUS';
    const CODE_POLE_GENOVA = 'GE';
    const CODE_POLE_PUGLIA_AR1 = 'AR1';
    const CODE_POLE_PUGLIA_AR2 = 'AR2';
    const CODE_POLE_PUGLIA_AR3 = 'AR3';

    const STRIPE_API_VERSION = 'SCA';

    private static $instance = null;

    private $paymentIntent = null;

    private $setupIntent = null;

    private function __construct()
    {
        $this->initStripe();
    }

    private function initStripe()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        if (env('STRIPE_API_VERSION') && env('STRIPE_API_VERSION') != '') {
            \Stripe\Stripe::setApiVersion(env('STRIPE_API_VERSION'));
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        $instance = self::$instance;
        return $instance;
    }
    /*
    private function __construct($company,$concession,$pole,$site)
    {
        $this->initStripe($company,$concession,$pole,$site);
    }

    private function initStripe($company,$concession,$pole,$site)
    {
        $collection = StripeAccount::active()->where('company_id',$company->id)->where('concession_id',$concession->id)->where('pole_id',$pole->id);
        if ($site){
            $collection->where('site_id',$site->id);
        }
        $stripe_account = $collection->first();

        \Stripe\Stripe::setApiKey($stripe_account->secret_key);
        \Stripe\Stripe::setApiVersion($stripe_account->api_version);
    }

    public static function getInstance($company,$concession,$pole,$site)
    {
        if (self::$instance == null) {
            $c = __CLASS__;
            self::$instance = new $c($company,$concession,$pole,$site);
        }

        $instance = self::$instance;
        return $instance;
    }
    */

    public function createChargesFromOrder($orderId)
    {
        $_cart = self::initCart();

        $order = SiaeOrder::find($orderId);
        if (!$order) {
            throw new \Exception('Order #' . $orderId . ' not found');
        }

        foreach ($order->items as $item) {
            $product = $item->product;
            $totalItem = ($item->qty * $product->price_sale) + $item->credit_card_fees;
            if ($item->product->service->product_category->name == "ticket") {

                $pole = $product->site ? $product->site->site->pole : 0;

                if (!empty($pole)) {
                    if ($pole->code == self::CODE_POLE_SIRACUSA) {
                        $_cart[self::CODE_POLE_SIRACUSA] += $totalItem;
                    }
                    if ($pole->code == self::CODE_POLE_MESSINA) {
                        $_cart[self::CODE_POLE_MESSINA] += $totalItem;
                    }
                    if ($pole->code == self::CODE_POLE_GENOVA) {
                        $_cart[self::CODE_POLE_GENOVA] += $totalItem;
                    }
                }
            } else {
                if ($product->service->is_pending) {

                } else {
                    $_cart[self::CODE_ADITUS] += $totalItem;
                }
            }
        }

        //self::transfer($_cart[self::CODE_POLE_SIRACUSA], 'SR1');
        //self::transfer($_cart[self::CODE_POLE_MESSINA], 'ME3');
        //self::transfer($_cart[self::CODE_ADITUS], 'ADITUS');

        $charge = Charge::create(array(
            "amount" => array_sum($_cart) * 100,
            "currency" => "eur",
            "capture" => true,
            "payment_intent" => $this->getPaymentIntent()->id
        ));

        return $this->getPaymentIntent()->id;
    }

    public function authorize_item($item)
    {
        $payment = Payment::find($item->payment_id);
        StripeApi::setApiKey(env('STRIPE_SECRET_KEY'));
        $this->getPaymentIntent()->capture(
            [
                'amount_to_capture' => $item->price * 100]);
    }

    public function refund($paymentIntentId, $amount)
    {
        $this->retrievePaymentIntent($paymentIntentId);
        $chargeId = $this->getPaymentIntent()->charges->data[0]->id;
        $re = \Stripe\Refund::create([
            "charge" => $chargeId,
            "amount" => $amount * 100
        ]);
    }

    public function transfer($source, $total, $destination)
    {
        $transfer = null;
        if ($total > 0) {
            switch ($destination) {
                case 'ME3':
                    $stripeAccountDestination = env('STRIPE_ACCOUNT_ME3');
                    break;
                case 'SR1':
                    $stripeAccountDestination = env('STRIPE_ACCOUNT_SR1');
                    break;
                case 'GE':
                    $stripeAccountDestination = env('STRIPE_ACCOUNT_GE');
                    break;
                case 'AR1':
                case 'AR2':
                case 'AR3':
                    $stripeAccountDestination = env('STRIPE_ACCOUNT_PU');
                    break;
                case 'ADITUS':
                default:
                    $stripeAccountDestination = env('STRIPE_ACCOUNT_ADITUS');
                    break;
            }

            $transfer = \Stripe\Transfer::create([
                "amount" => $total * 100,
                "currency" => "eur",
                "source_transaction" => $source,
                "destination" => $stripeAccountDestination
            ]);
        }
        return $transfer;
    }

    static function initCart()
    {
        $_cart[self::CODE_POLE_MESSINA] = 0;
        $_cart[self::CODE_POLE_SIRACUSA] = 0;
        $_cart[self::CODE_POLE_GENOVA] = 0;
        $_cart[self::CODE_ADITUS] = 0;

        return $_cart;
    }

    static function calculateFees($price)
    {
        return $price / 100 * self::TRANSACTION_PERCENTAGE;
    }

    public function createManualPaymentIntent($paymentMethodId, $totalAmount = null, $email = null)
    {
        if ($totalAmount) {
            $amount = $totalAmount * 100;
        } else {
            $cart = Cart::cartInfos();
            $amount = $cart->cart_confirmed_total * 100 ?: 0;
        }


        if ($amount > 0) {
            $customer = $email ? $this->createCustomer($email) : null;
            $intent = \Stripe\PaymentIntent::create([
                'payment_method' => $paymentMethodId,
                'amount' => $amount,
                'currency' => 'eur',
                'confirmation_method' => 'manual',
                'capture_method' => 'manual',
                'confirm' => true,
                'customer' => $customer ? $customer->id : null,
                'setup_future_usage' => 'off_session'
            ]);
        } else {
            $intent = \Stripe\SetupIntent::retrieve($paymentMethodId);
        }


        $this->paymentIntent = $intent;
    }


    public function createIntent()
    {
        $cart = Cart::cartInfos();
        $amount = $cart->cart_total ?: 0;
        if ($amount > 0) {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount * 100,
                'currency' => 'eur',
                'payment_method_types' => ['card'],
                'confirmation_method' => 'manual',
                'confirm' => true
            ]);
            $this->paymentIntent = $paymentIntent;
        }

    }

    public function createCustomer($email)
    {
        $customer = \Stripe\Customer::create(array(
            'email' => $email
        ));

        return $customer;
    }

    public function updateIntent($newAmount)
    {
        $this->paymentIntent = \Stripe\PaymentIntent::update([
            'amount' => $newAmount
        ]);
    }

    public function getSetupIntent()
    {
        return $this->setupIntent;
    }

    public function getPaymentIntent()
    {
        return $this->paymentIntent;
    }

    public function retrieveIntent($paymentIntentId)
    {
        $this->intent = \Stripe\StripeObject($paymentIntentId);
    }

    public function retrievePaymentIntent($paymentIntentId)
    {
        $this->paymentIntent = $paymentIntentId ? \Stripe\PaymentIntent::retrieve($paymentIntentId) : null;
    }

    public function retrieveSetupIntent($setupIntentId)
    {
        $this->setupIntent = $setupIntentId ? \Stripe\SetupIntent::retrieve($setupIntentId) : null;
    }

    public function generatePaymentResponse()
    {

        if (!$this->paymentIntent && !$this->setupIntent) {
            $response = ['error' => ['title' => 'Errore durante l\'esecuzione dell\'ordine']];
        }
        else if($this->setupIntent){
            $response = [
                'success' => true,
                'setup_intent_id' => $this->setupIntent->id
            ];
        }
        else if ($this->paymentIntent->status == self::getRequireActionStatus() &&
            $this->paymentIntent->next_action->type == 'use_stripe_sdk') {
            # Tell the client to handle the action
            $response = [
                'requires_action' => true,
                'payment_intent_client_secret' => $this->paymentIntent->client_secret
            ];
        } else if ($this->paymentIntent->status == 'requires_capture') {
            $response = [
                'success' => true,
                'payment_intent_id' => $this->paymentIntent->id
            ];
        } else if ($this->paymentIntent->status == 'requires_confirmation') {
            $this->paymentIntent->confirm();
            $response = [
                'success' => true,
                'payment_intent_id' => $this->paymentIntent->id
            ];
        } else if ($this->paymentIntent->status == 'succeeded') {
            $response = [
                'success' => true,
                'payment_intent_id' => $this->paymentIntent->id

            ];
        } else {
            # Invalid status
            http_response_code(500);
            $response = ['error' => ['title' => 'Invalid PaymentIntent status']];
        }
        return $response;
    }


    static function getRequireActionStatus()
    {
        if (self::STRIPE_API_VERSION == 'LEGACY') {
            return 'requires_source_action';
        } elseif (self::STRIPE_API_VERSION == 'SCA') {
            return 'requires_action';
        }

    }

    public function attachCustomerToPaymentMethod($paymentMethodId)
    {
        $customer = '';
        $payment_method = \Stripe\PaymentMethod::retrieve($paymentMethodId);
        $payment_method->attach(['customer' => $customer]);

        \Stripe\PaymentMethod::update(
            $paymentMethodId,
            ['billing_details' => ['email' => Auth::guard('web')->user()->email]]
        );

    }

    public static function decodeError($errorCode)
    {
        $error = __('stripe.' . $errorCode);
        return ['error' => [
            'title' => $error['description'] ?? '',
            'subtitle' => $error['next_steps'] ?? ''
        ]];
    }

    public static function logTransfer($transfer, $object, $error = null)
    {
        switch ($object) {
            case $object instanceof OrderItem:
                $modelType = 'orderItem';
                $paymentId = $object->order->payment->id;
                break;
            case $object instanceof Order :
                $modelType = 'order';
                $paymentId = $object->payment->id;
                break;
        }

        $transferLog = new PaymentTransfer();
        $transferLog->payment_id = $paymentId;
        $transferLog->model_type = $modelType;
        $transferLog->model_id = $object->id;

        if ($transfer) {
            $transferLog->tr_id = $transfer->id;
            $transferLog->tr_amount = number_format($transfer->amount / 100, 2, '.', '');
            $transferLog->tr_destination = $transfer->destination;
            $transferLog->py_id = $transfer->destination_payment;
            $transferLog->status = PaymentTransfer::STATUS_TYPE_TRANSFERRED;
        } else {
            $transferLog->status = PaymentTransfer::STATUS_TYPE_ERROR;
            $transferLog->notes = isset($error) ? $error->getMessage() : '';
        }

        $transferLog->save();

        return $transferLog;

    }

    static function getAccountById($accountId)
    {
        $stripeAccountDestination = '';
        switch ($accountId) {
            case env('STRIPE_ACCOUNT_ME3'):
                $stripeAccountDestination = 'TAORMINA';
                break;
            case env('STRIPE_ACCOUNT_SR1'):
                $stripeAccountDestination = 'SIRACUSA';
                break;
            case env('STRIPE_ACCOUNT_ADITUS'):
                $stripeAccountDestination = 'ADITUS';
                break;
            case env('STRIPE_ACCOUNT_GE'):
                $stripeAccountDestination = 'GENOVA';
                break;
            case env('STRIPE_ACCOUNT_PU'):
                $stripeAccountDestination = 'PUGLIA';
                break;
        }
        return $stripeAccountDestination;
    }

    public function transferByOrder($order) {
        $this->retrievePaymentIntent($order->payment->code);
        $paymentIntent = $this->getPaymentIntent();
        if (!isset($paymentIntent)) {
            return;
        }

        $orderFee = 0;

        foreach ($paymentIntent->charges->data as $charge) {
            StripePaymentIntent::createIfNotExists($paymentIntent, $charge);
            if ($charge->balance_transaction != '') {
                $transaction = BalanceTransaction::retrieve($charge->balance_transaction);
                $orderFee += $transaction->fee/100;
                $source = $charge->id;
            }
        }
        $order->payment->fee = number_format($orderFee, 2);
        $order->payment->save();

        foreach ($order->items as $orderItem) {
            $totalToTransfer = $order->getTotalToTransfer($orderItem->price);
            $destination = $orderItem->product->stripe_destination;
            $this->transferAmount($orderItem, $source, $totalToTransfer, $destination);
        }
        if ($order->bollo > 0 && is_null($order->payment_transfer_id)) {
            $totalToTransfer = $order->getTotalToTransfer($order->bollo);
            $this->transferAmount($order, $source, $totalToTransfer, $destination);
        }
    }

    public function transferAmount($object, $source, $amount, $destination) {
        DB::beginTransaction();
        try {
            $transfer = $this->transfer($source, $amount, $destination);
            $paymentTransfer = $this->logTransfer($transfer, $object);
        } catch (\Exception $e) {
            DB::rollback();
            $paymentTransfer = $this->logTransfer(null, $object, $e);
            Mail::sendErrorReporting($e);
        }
        $object->payment_transfer_id = $paymentTransfer->id;
        $object->save();
        DB::commit();
    }

}
