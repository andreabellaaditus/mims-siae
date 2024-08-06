<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSubcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_category_id',
        'slug',
        'name',
        'active',
    ];

    public function product_category() : BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope);
    }
}
