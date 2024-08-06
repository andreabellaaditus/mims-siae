<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessControlChange extends Model
{
    protected $table = 'access_control_changes';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'access_control_device_id', 'message'
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
