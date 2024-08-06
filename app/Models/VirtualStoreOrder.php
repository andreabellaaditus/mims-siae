<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualStoreOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'qty',
        'user_id',
        'status',
        'description',
        'email',
        'order_file',
        'can_delete'
    ];

}
