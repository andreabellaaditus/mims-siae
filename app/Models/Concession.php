<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concession extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'active',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope);
    }
}
