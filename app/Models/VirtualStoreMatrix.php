<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualStoreMatrix extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'lot_id',
        'code',
        'year',
        'progressive',
        'status',
        'purchase_group',
        'purchased_at'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
