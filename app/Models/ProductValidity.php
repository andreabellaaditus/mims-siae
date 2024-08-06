<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductValidity extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'start_validity',
        'end_validity'
    ];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
