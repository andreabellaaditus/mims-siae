<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashierActive extends Model
{
    use HasFactory;
    protected $table = 'cashiers_active';
    protected $fillable = [
        'user_id',
        'cashier_id',
        'created_at',
        'updated_at',
    ];
}
