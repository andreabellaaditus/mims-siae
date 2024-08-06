<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'address',
        'post_code',
        'city',
        'county',
        'country_id',
        'phone',
        'vat',
        'tax_code',
        'iban',
        'certified_email',
        'unique_code',
        'idTransmitter',
        'idTransferorLender',
        'taxRegime',
        'reaOffice',
        'reaNum',
        'reaStatus',
        'logo',
    ];

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }
}
