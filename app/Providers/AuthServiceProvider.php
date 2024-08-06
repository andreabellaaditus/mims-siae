<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Cashier;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\StaffPolicy;
use App\Policies\CashierPolicy;
use App\Policies\ActivityPolicy;
// use App\Policies\CashierPolicy;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Activitylog\Models\Activity;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        Staff::class => StaffPolicy::class,
        Cashier::class => CashierPolicy::class,
        Activity::class => ActivityPolicy::class,
        // Cashier::class => CashierPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
