<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CartProduct extends Pivot
{
    use HasFactory;
    protected $table = 'cart_products';

    protected $fillable = [
        'cart_id',
        'product_id',
        'date_service',
        'hour_service',
        'holder_last_name',
        'holder_first_name',
        'open_ticket'
    ];

        public function cart(): BelongsTo
        {
            return $this->belongsTo(Cart::class);
        }

        public function product(): BelongsTo
        {
            return $this->belongsTo(Product::class);
        }


}
