<?php

namespace App\Http\Helpers;

use App\Order;
use App\Payment;
use App\Product;
use App\ProductSite;
use Stripe\Stripe as StripeApi;
use Stripe\Customer;
use Stripe\Charge;
use Stripe\Account;
use Stripe\Transfer;
use Stripe\Balance;


class Stripe
{


    const TRANSACTION_PERCENTAGE = 0;
    const TRANSACTION_FEE = 0;

    const CODE_POLE_SIRACUSA = 'SR1';
    const CODE_POLE_MESSINA = 'ME3';
    const CODE_ADITUS = 'ADITUS';
    const CODE_POLE_GENOVA = 'GE';

    static function calculateFees($price)
    {
        return $price/100*self::TRANSACTION_PERCENTAGE;
    }

/*
    static function createChargesFromOrder($orderId, $token)
    {
        $_cart = self::initCart();

        $order = Order::find($orderId);
        if (!$order) {
            throw new \Exception('Order #' . $orderId . ' not found');
        }


        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $customer = Customer::create(array(
            'email' => $order->user->email,
            'source' => $token,
        ));

        foreach ($order->items as $item) {
            $product = $item->product;
            $totalItem = ($item->qty * $product->price_sale)+$item->credit_card_fees;
            if ($item->product->service->product_category->slug == "tickets") {

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
                    $is_pending = true;
                    $chargePending = Charge::create(array(
                        'customer' => $customer->id,
                        "amount" => $totalItem * 100,
                        "currency" => "eur",
                        "capture" => ((!$is_pending) ? true : false),
                        "destination" => env('STRIPE_ACCOUNT_ADITUS')
                    ));

                    $payment_id = Payment::insertGetId([
                        'gateway' => 'stripe',
                        'code' => $chargePending->id,
                        'total' => $totalItem
                    ]);

                    $item->payment_id = $payment_id;
                    $item->save();
                } else {
                    $_cart[self::CODE_ADITUS] += $totalItem;
                }
            }
        }

        if (array_sum($_cart) * 100 == 0) {
            return 'free';
        }

        $charge = Charge::create(array(
            'customer' => $customer->id,
            "amount" => array_sum($_cart) * 100,
            "currency" => "eur",
            "capture" => true
        ));

        if (isset($charge->id) && $charge->id != "") {

            //self::transfer($charge,$_cart[self::CODE_POLE_SIRACUSA],'SR1');
            //self::transfer($charge,$_cart[self::CODE_POLE_MESSINA],'ME3');
            //self::transfer($charge,$_cart[self::CODE_ADITUS],'ADITUS');

            if ($order->has_experience && 1 != 1) { //COMMENTATO IN ATTESA DI RISOLUZIONE PROBLEMA CON STRIPE
                $transfer_fee = Transfer::create(array(
                    "amount" => (array_sum($_cart) * (self::TRANSACTION_PERCENTAGE / 100)) * 100,
                    "currency" => "eur",
                    "destination" => env('STRIPE_ACCOUNT_ADITUS'),
                    "source_transaction" => $charge->id,
                ));
            }

            $chargeId = $charge->id;
        } else {
            $chargeId = 'free';
        }
        return $chargeId;
    }

    static function authorize_item($item)
    {
        $payment = Payment::find($item->payment_id);
        StripeApi::setApiKey(env('STRIPE_SECRET_KEY'));
        $charge = Charge::retrieve($payment->code);
        $charge->capture();
    }

    static function transfer($charge, $total, $destination)
    {
        if($total > 0)
        {
            switch ($destination)
            {
                case 'ME3':
                    $stripeAccountDestination = env('STRIPE_ACCOUNT_ME3');
                    break;
                case 'SR1':
                    $stripeAccountDestination = env('STRIPE_ACCOUNT_SR1');
                    break;
                case 'GE':
                    $stripeAccountDestination = env('STRIPE_ACCOUNT_GE');
                    break;
                case 'ADITUS':
                default:
                    $stripeAccountDestination = env('STRIPE_ACCOUNT_ADITUS');
                    break;
            }

            Transfer::create(array(
                "amount" => $total * 100,
                "currency" => "eur",
                "destination" => $stripeAccountDestination,
                "source_transaction" => $charge->id,
            ));
        }

    }

    static function initCart()
    {
        $_cart[self::CODE_POLE_MESSINA] = 0;
        $_cart[self::CODE_POLE_SIRACUSA] = 0;
        $_cart[self::CODE_ADITUS] = 0;
        $_cart[self::CODE_POLE_GENOVA] = 0;

        return $_cart;
    }

*/
}
