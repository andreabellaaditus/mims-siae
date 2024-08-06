<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCumulative extends Pivot
{
    use HasFactory;

    protected $table = 'product_cumulatives';
    protected $fillable = [
        'product_id',
        'site_id',
        'max_scans'
    ];
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }


}
