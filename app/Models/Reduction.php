<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'short_name',
        'active',
        'reduction_type',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope);
    }
}
