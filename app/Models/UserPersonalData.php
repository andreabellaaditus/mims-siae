<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class UserPersonalData extends Model
{
    protected $fillable = [
        'user_id',
        'date_of_birth',
        'contract_qualification_id',
        'mobile_number',
        'tax_code',
        'city',
        'address',
        'post_code',
        'city_alt',
        'post_code_alt',
        'address_alt',
        'post_code_alt',
        'qualification',
        'size',
        'classification_level',
        'engagement_date',
        'termination_date',
        'subsidiary_id',
        'geobadge_id',
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contract_qualification(): BelongsTo
    {
        return $this->belongsTo(ContractQualification::class);
    }
}
