<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contract_type_id',
        'contract_start_date',
        'contract_end_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contract_type(): BelongsTo
    {
        return $this->belongsTo(ContractType::class);
    }
}
