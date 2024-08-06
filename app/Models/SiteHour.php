<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class SiteHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'site_id',
        'opening',
        'closing',
        'closing_ticket_office',
        'break_start',
        'break_end',
        'start_validity',
        'end_validity'
    ];


    protected $casts = [
        'day' => AsArrayObject::class
    ];

}
