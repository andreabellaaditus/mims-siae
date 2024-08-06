<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSaleMatrix extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'type_channel',
        'type_user',
        'matrix_value',
    ];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
