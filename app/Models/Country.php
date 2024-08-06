<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'continent_id',
    ];

    public function continent() : BelongsTo
    {
        return $this->belongsTo(Continent::class);
    }

    public function scopeOrdered($query,$name)
    {
        return $query->orderByRaw('case when name = "'.$name.'" then 1 else 2 end, name asc');
    }
}
