<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_date',
        'course_description',
        'course_duration',
        'course_validity',
        'course_expiry',
        'course_effectiveness_description',
        'course_effectiveness_evaulation',
        'course_effectiveness_date',
        'created_at',
        'updated_at',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}


