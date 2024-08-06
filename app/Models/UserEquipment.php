<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEquipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assignment_equipment_date',
        'restitution_equipment_date',
        'equipment_size',
        'equipment_registration_number',
        'equipment_description',
        'created_at',
        'updated_at',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
