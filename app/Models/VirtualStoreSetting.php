<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VirtualStoreSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'value',
        'key',
        'active',
        'product_id'
    ];

}
