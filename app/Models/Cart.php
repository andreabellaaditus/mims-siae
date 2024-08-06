<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cart_products',
    ];


    public function cart_products(): HasMany
    {
        return $this->HasMany(CartProduct::class);
    }

    public function getConfirmedTotal()
    {
        return $this->cart_products
            ->filter(function ($cartProduct) {
                return isset($cartProduct->product);
            })
            ->filter(function ($cartProduct) {
                return isset($cartProduct->product->service);
            })
            ->filter(function ($cartProduct) {
                return $cartProduct->product->service->is_pending != 1;
            })
            ->sum(function($cartProduct) {
                $product = $cartProduct->product;
                $productCategory = $product->service->product_category;
                $totalPrice = 0;

                if (isset($productCategory) && $productCategory->name == 'site-events'){
                    $totalPrice = $product->price_web;
                } else {
                    $totalPrice = isset($product) ? $product->price_sale + $product->fee : 0;
                }

                if (count($product->related_products) > 0) {
                    foreach ($product->related_products as $relatedProduct) {
                        $totalPrice += $relatedProduct->price_sale;
                    }
                }

                return $totalPrice;
            });
    }

}
