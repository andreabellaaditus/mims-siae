<?php

namespace App\Services;
use App\Models\CartProduct;
use App\Models\Product;
use App\Services\SlotService;
use App\Models\ReductionField;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;

class CartProductService
{
    public float $total = 0.00;
    public array $products = array();
    public function emptyByCartId($cart_id){
        CartProduct::where('cart_id', $cart_id)->delete();
    }

    public function updateByProduct($product_id, $data){
        return CartProduct::where('product_id', $product_id)->update($data);
    }


    public function getCartTotal($user_id){
        $query = Product::query()
        ->join('cart_products', 'products.id', '=', 'cart_products.product_id')
        ->join('carts', 'carts.id', '=', 'cart_products.cart_id')
            ->selectRaw('products.id, (price_sale * COUNT(cart_products.product_id)) as total, COUNT(cart_products.product_id) as qty')
            ->where('carts.user_id', $user_id)
            ->groupBy('cart_products.product_id')
            ->groupBy('cart_products.cart_id')
            ->orderByRaw('cart_products.product_id')->get();

        $price = 0.00;

        foreach($query as $row){
            $product = Product::find($row->id);
            $price+= $row->total;
            foreach($product->related_products AS $rel_prod){
                $price += $rel_prod->price_sale * $row->qty;
            }
        }

        return number_format($price, 2, ',')." €";
    }

    public function getProducts($user_id, $site_id){
        $query = Product::query()
        ->join('cart_products', 'products.id', '=', 'cart_products.product_id')
        ->join('carts', 'carts.id', '=', 'cart_products.cart_id')
        ->join('services', 'services.id', '=', 'products.service_id')
            ->selectRaw('cart_products.cart_id, products.id, products.vat, products.name, price_sale, products.is_link, products.product_link,
            COUNT(cart_products.product_id) as qty, (price_sale * COUNT(cart_products.product_id)) as total')
            ->where('carts.user_id', $user_id)
            ->where('services.site_id', $site_id)
            ->groupBy('cart_products.product_id')
            ->groupBy('cart_products.cart_id')
            ->orderByRaw('cart_products.product_id')->withoutGlobalScope(ActiveScope::class);

        return $query;
    }
    public function getReductionFields($cart, $site_id = 1) {
        $this->products = [];

        $cart->cart_products
            ->groupBy('product_id')
            ->each(function($cartProductsByProduct, $productId) use($site_id) {
                $qty = $cartProductsByProduct->count();
                $cartProduct = $cartProductsByProduct->first();
                $product = $cartProduct->product;


                if ($product->is_name) {
                    $fields[-1] = [
                        'name' => 'Nome',
                        'product_id' => $product->id,
                        'reduction_id' => 'first_name',
                        'reduction_field_id' => 0,
                    ];
                    $fields[-2] = [
                        'name' => 'Cognome',
                        'product_id' => $product->id,
                        'reduction_id' => 'last_name',
                        'reduction_field_id' => -1,
                    ];
                }else{
                    $productService = new ProductService($product);
                    $fields = $productService->getReductionFields();

                }

                if ($product->service->site_id == $site_id) {
                    $this->products[$product->id] = [
                        'name' => $product->name,
                        'check_document' => $product->check_document,
                        'is_name' => $product->is_name,
                        'qty' => $qty,
                        'fields' => $fields
                    ];
                }
            });

        return $this->products;
    }

    public function getGroupedSlots($cart, $site_id = 1){
        $this->products = array();

        $cart->cart_products
        ->groupBy('product_id')
        ->each(function($cartProductsByProduct) use($cart, $site_id){

            $cartProductsByProduct->groupBy('date_service')
            ->each(function($cartProductsByDateService) use($cart, $site_id){
                $cartProductsByDateService
                ->groupBy('hour_service')
                ->each(function($cartProductsByHourService) use($cart, $site_id) {
                    $cartProduct = $cartProductsByHourService->first();
                    $product = $cartProduct->product;
                    if($product){
                        $service = $product->service;
                    }
                    $qty = $cartProductsByHourService->count();

                    $hours = array();
                    $slotService = new SlotService();
                    $hours = $slotService->getSlots('product_id', $product->id, $cartProduct->date_service, session('site_id'));
                    if(empty($hours)){
                        $hours = $slotService->getSlots('service_id', $product->service_id, $cartProduct->date_service, session('site_id'));
                    }

                    $is_date = $product->is_date;
                    $is_hour = $product->is_hour;

                    if($product->is_date || $product->is_hour){
                        $this->updateByProduct($product->id, ['open_ticket' => 0]);
                        $cartProduct->open_ticket = 0;
                    }elseif($service->is_date || $service->is_hour){
                        $this->updateByProduct($product->id, ['open_ticket' => 0]);
                        $cartProduct->open_ticket = 0;
                        $is_date = $service->is_date;
                        $is_hour = $service->is_hour;
                    }

                    $online_reservation_delay = (isset($product->online_reservation_delay)) ? $product->online_reservation_delay : $service->online_reservation_delay;
                    $date_start = Carbon::today()->addDays($online_reservation_delay)->format('Y-m-d');

                    if($product->service->site_id == $site_id){
                        $this->products[$product->id] = array(
                            'name' => $product->name,
                            'exclude_slotcount' => $product->exclude_slotcount,
                            'is_date' => $is_date,
                            'is_hour' => $is_hour,
                            'is_name' => $product->is_name,
                            'dateStart' => $date_start,
                            'cart_id' => $cart->id,
                            'hours' => $hours,
                            'qty' => $qty,
                            'cart_product_id' => $cartProduct->id,
                            'hour_service' => $cartProduct->hour_service,
                            'date_service' => $cartProduct->date_service,
                            'open_ticket' => $cartProduct->open_ticket,
                        );
                    }


                });
            });
        });

        return $this->products;
    }

    public function searchIdenticalProducts($conditions){
        return CartProduct::where($conditions)->whereNotNull('date_service')->first();
    }

    public function create($data){
        return CartProduct::Create($data);
    }

    public function deleteOne($conditions){
        return CartProduct::where($conditions)->first()->delete();
    }

    public function deleteProductGroup($conditions){
        return CartProduct::where($conditions)->delete();
    }

    public function getProductGroup($conditions){
        return CartProduct::where($conditions)->get()->first();
    }

    public function switchIsCumulative($conditions){

        return CartProduct::where($conditions)
        ->update(['is_cumulative' => DB::raw('NOT is_cumulative')]);

    }


}

