<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiaeScanLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_code', 'type', 'site_id', 'status', 'response', 'product_id'
    ];
}
