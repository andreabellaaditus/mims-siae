<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessControlDevice extends Model
{
    protected $table = 'access_control_devices';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'area', 'type',	'site_id', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function site(){
        return $this->belongsTo(Site::class);
    }

}
