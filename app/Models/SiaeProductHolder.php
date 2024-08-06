<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiaeProductHolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'siae_order_item_id',
        'product_id',
        'first_name',
        'last_name',
        'expired_at'
    ];

}
