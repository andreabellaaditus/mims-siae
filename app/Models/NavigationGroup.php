<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class NavigationGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'name',
        'icon',
        'active',
        'roles',
    ];

    protected $casts = [
        'roles' => AsArrayObject::class,
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope);
    }
}
