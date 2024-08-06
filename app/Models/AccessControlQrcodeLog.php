<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessControlQrcodeLog extends Model
{
    protected $table = 'access_control_qrcode_logs';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id', 'qr_code', 'direction'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];


    public function access_control_device(){
        return $this->belongsTo(AccessControlDevice::class);
    }

}
