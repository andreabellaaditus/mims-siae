<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'active'
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope);
    }


}
