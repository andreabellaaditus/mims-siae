<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMedicalVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'visit_date',
        'visit_expiry',
        'visit_description',
        'visit_duration',
        'created_at',
        'updated_at',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
