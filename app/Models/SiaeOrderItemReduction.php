<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiaeOrderItemReduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'siae_order_item_id',
        'reduction_id',
        'reduction_field_id',
        'value',

    ];
}
