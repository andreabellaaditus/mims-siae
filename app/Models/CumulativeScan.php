<?php

namespace App\Models;

use App\Models\ProductCumulative;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class CumulativeScan extends Model
{

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'site_id', 'scans', 'qr_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];


    public function site(){
        return $this->belongsTo(Site::class);
    }

    public function cumulative_product(){
        return $this->belongsTo(ProductCumulative::class);
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
