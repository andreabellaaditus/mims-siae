<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentSubtype extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_type_id',
        'slug',
        'name',
        'active',
        'fee_percentage',
        'fee_value',
    ];

    public function payment_type(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope);
    }
}
