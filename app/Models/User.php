<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;

use App\Services\UserService;
use App\Models\UserMedicalVisit;
use App\Models\UserCourse;
use App\Models\UserPersonalData;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Cashier\Billable;
use Illuminate\Support\Facades\Config;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string|null $name
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property Carbon|null $password_expired_at
 * @property Carbon|null $first_login_at
 * @property int $active
 * @property int $anonymized
 * @property Carbon|null $anonymized_at
 * @property Carbon|null $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $last_login_at
 * @property int|null $siae_operator_id
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserContract> $user_contracts
 * @property-read int|null $user_contracts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, UserCourse> $user_courses
 * @property-read int|null $user_courses_count
 * @property-read \App\Models\UserDetail|null $user_detail
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserEquipment> $user_equipments
 * @property-read int|null $user_equipments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, UserMedicalVisit> $user_medical_visits
 * @property-read int|null $user_medical_visits_count
 * @property-read UserPersonalData|null $user_personal_data
 * @property-read \App\Models\UserSite|null $user_site
 * @method static \Illuminate\Database\Eloquent\Builder|User cashier()
 * @method static \Illuminate\Database\Eloquent\Builder|User external()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User hasExpiredGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|User internal()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder|User school()
 * @method static \Illuminate\Database\Eloquent\Builder|User staff()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAnonymized($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAnonymizedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePasswordExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSiaeOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable implements FilamentUser, HasName, JWTSubject
{
    use Billable;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    use HasRoles;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'active',
        'email_verified_at',
        'password_expired_at',
        'first_login_at',
        'last_login_at',
        'anonymized'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password_expired_at' => 'datetime',
        'first_login_at' => 'datetime',
        'last_login_at' => 'datetime',
        'deleted_at' => 'datetime',
        'anonymized_at' => 'datetime',
    ];
    protected $with = ['roles', 'permissions'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function stripeOptions()
    {
        return [
            'api_key' => env('STRIPE_SECRET_KEY'),
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function user_detail() : HasOne
    {
        return $this->hasOne(UserDetail::class);
    }

    public function user_medical_visits() : HasMany
    {
        return $this->hasMany(UserMedicalVisit::class);
    }

    public function user_courses() : HasMany
    {
        return $this->hasMany(UserCourse::class);
    }

    public function user_equipments() : HasMany
    {
        return $this->hasMany(UserEquipment::class);
    }

    public function user_contracts() : HasMany
    {
        return $this->hasMany(UserContract::class);
    }

    public function user_personal_data() : HasOne
    {
        return $this->hasOne(UserPersonalData::class);
    }

    public function user_site() : HasOne
    {
        return $this->hasOne(UserSite::class);
    }


    public function scopeStaff($query)
    {
        return $query->whereHas('roles', function($roles){
            $roles->where('name',UserService::ROLE_ADMIN);
        });
    }

    public function scopeInternal($query)
    {
        return $query->whereHas('roles', function($roles){
            $roles->where('name',UserService::ROLE_INTERNAL_STAFF);
        });
    }

    public function scopeExternal($query)
    {
        return $query->whereHas('roles', function($roles){
            $roles->where('name',UserService::ROLE_EXTERNAL_STAFF);
        });
    }

    public function scopeCashier($query)
    {
        return $query->whereHas('roles', function($roles){
            $roles->where('name',UserService::ROLE_CASHIER);
        });
    }

    public function scopeSchool($query)
    {
        return $query->whereHas('roles', function($roles){
            $roles->where('name',UserService::ROLE_SCHOOL);
        });
    }

    public function scopeTravelAgency($query)
    {
        return $query->whereHas('roles', function($roles){
            $roles->where('name', UserService::ROLE_TRAVEL_AGENCY);
        });
    }

    public function scopeCommercial($query)
    {
        return $query->whereHas('roles', function($roles){
            $roles->where('name', UserService::ROLE_COMMERCIAL);
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;//$this->hasVerifiedEmail();
    }

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['first_name','last_name','email'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
