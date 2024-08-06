<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'product_id',
        'slot_days',
        'slot_type',
        'hours',
        'duration',
        'delay_tolerance',
        'advance_tolerance',
        'availability',
    ];

    protected $casts = [
        'slot_days' => AsArrayObject::class,
        'hours' => AsArrayObject::class,
    ];

    public function service() : BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
