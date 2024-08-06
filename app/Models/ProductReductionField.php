<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReductionField extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'reduction_fields'
    ];

    protected $casts = [
        'reduction_fields' => AsArrayObject::class,
    ];

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
