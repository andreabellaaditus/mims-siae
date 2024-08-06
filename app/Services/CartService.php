<?php

namespace App\Services;
use App\Models\Cart;
use App\Models\ReductionField;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;

class CartService
{

    public function create($data){

        return Cart::create($data);

    }

    public function update($conditions, $data){

        return Cart::where($conditions)
        ->update($data);

    }

    public function empty($cart_id){
        return Cart::where('id', $cart_id)->delete();
    }


    public function getCart($user_id){

        return Cart::where('user_id', $user_id)->with('cart_products')->first();

    }

    public function checkExisting($user_id){

        return Cart::where('user_id', $user_id)->exists();

    }
}
