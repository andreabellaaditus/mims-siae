<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'notification_frequency',
        'recipients',
    ];

    protected $casts = [
        'notification_frequency' => AsArrayObject::class,
    ];

    public function service() : BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /*public function notification_frequency() : BelongsTo
    {
        return $this->belongsTo(NotificationFrequency::class);
    }*/
}
