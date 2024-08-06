<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class AccessControlPass extends Model
{
    protected $table = 'access_control_pass';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'issued_by', 'enabled_sites', 'qr_code', 'first_name', 'last_name', 'expire_at'
    ];
    protected $casts = [
        'enabled_sites' => AsArrayObject::class,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function getEnabledSitesIdsAttribute()
    {
        $enabledSites = $this->enabled_sites->toArray();
        return $enabledSites;
    }

    public function getEnabledSitesLabelsAttribute()
    {
        $enabledSitesIds = $this->enabledSitesIds;
        $enabledSites = Site::whereIn('id', $enabledSitesIds)->get();

        $enabledSitesLabels = [];

        foreach ($enabledSites as $enabledSite) {
            $enabledSitesLabels[] = $enabledSite->short_name;
        }


        return $enabledSitesLabels;
    }


    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function getIssuedAtAttribute()
    {
        $issuedAt = Carbon::parse($this->created_at);
        return $issuedAt;
    }

    public function getExpireDateAttribute()
    {
        $expireAt = Carbon::parse($this->expire_at);
        return $expireAt;
    }

}
