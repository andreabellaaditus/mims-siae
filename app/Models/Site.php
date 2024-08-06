<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'pole_id',
        'company_id',
        'concession_id',
        'unlock_matrix_pole_id',
        'slug',
        'name',
        'canonical_name',
        'address',
        'city',
        'region',
        'lat',
        'lng',
        'is_comingsoon',
        'is_closed',
        'in_concession',
        'matrix_suffix',
        'access_control_enabled',
        'poll_enabled',
        'cashier_fee_enabled',
        'tvm',
        'onsite_auto_scan',
        'cod_location_siae',
    ];

    public function pole() : BelongsTo
    {
        return $this->belongsTo(Pole::class);
    }

    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function concession() : BelongsTo
    {
        return $this->belongsTo(Concession::class);
    }

    public function unlock_pole() : BelongsTo
    {
        return $this->belongsTo(Pole::class, 'unlock_matrix_pole_id', 'id');
    }

    public function cashiers(): HasMany
    {
        return $this->hasMany(Cashier::class);
    }

    public function hours(): HasMany
    {
        return $this->hasMany(SiteHour::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('is_closed',0);
    }
}
