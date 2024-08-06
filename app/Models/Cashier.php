<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cashier extends User
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'cashier_type',
        'code',
        'name',
        'active',
        'has_shifts',
        'email_verified_at',
        'password_expired_at',
        'first_login_at'
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(SiaeOrder::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope);
    }
}
