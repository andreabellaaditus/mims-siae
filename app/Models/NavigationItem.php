<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NavigationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'navigation_group_id',
        'navigation_sort',
        'groupException',
        'active',
        'roles',
    ];

    protected $casts = [
        'roles' => AsArrayObject::class,
    ];

    public function navigation_group() : BelongsTo
    {
        return $this->belongsTo(NavigationGroup::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope);
    }
}
