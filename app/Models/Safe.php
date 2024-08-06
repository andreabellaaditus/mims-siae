<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Safe extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'name'
    ];


    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function safe_operations(): HasMany
    {
        return $this->hasMany(SafeOperation::class);
    }
}
