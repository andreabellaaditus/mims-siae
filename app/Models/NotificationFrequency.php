<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotificationFrequency extends Model
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
