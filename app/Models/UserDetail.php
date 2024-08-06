<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'business_name',
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
        'cig',
        'is_subcontractor',
        'contractor_id',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country() : BelongsTo
    {
        return $this->belongsTo(Country::class)->ordered("Italy");
    }

    public function contractor() : BelongsTo
    {
        return $this->belongsTo(User::class, 'contractor_id', 'id');
    }
}
