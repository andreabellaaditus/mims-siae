<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractQualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'active',
    ];

    public function scopeActive($query)
    {
        return $query->where('active',1);
    }
}
