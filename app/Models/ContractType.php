<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractType extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'active',
        'contract_hours',
        'monthly_hours',
        'weekly_hours_ls',
        'weekly_hours_hs',
        'daily_hours',
        'holiday_per_month',
        'whr_per_month',
        'priority',
    ];

    public function scopeActive($query)
    {
        return $query->where('active',1);
    }
}


