<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SafeOperation extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'user_id',
        'amount',
        'operation_date',
        'surname',
        'company',
        'created_at',
        'updated_at',
        'name'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
