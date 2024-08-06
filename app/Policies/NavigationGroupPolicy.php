<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NavigationGroup;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Services\NavigationRoleService;
use App\Trait\OperationsForPolicy;

class NavigationGroupPolicy
{
    use HandlesAuthorization;

    use OperationsForPolicy;
    const SLUG_NAVIGATION_ITEMS = 'navigation-groups';

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {

        $rolesService = new NavigationRoleService;
        $roles = $rolesService->rolesNavigationFromSlugPolicy($this::SLUG_NAVIGATION_ITEMS, $this::VIEWANY);

        return $user->hasAnyRole($roles);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, NavigationGroup $navigationGroup): bool
    {

        $rolesService = new NavigationRoleService;
        $roles = $rolesService->rolesNavigationFromSlugPolicy($this::SLUG_NAVIGATION_ITEMS, $this::VIEW);

        return $user->hasAnyRole($roles);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {

        $rolesService = new NavigationRoleService;
        $roles = $rolesService->rolesNavigationFromSlugPolicy($this::SLUG_NAVIGATION_ITEMS, $this::CREATE);

        return $user->hasAnyRole($roles);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, NavigationGroup $navigationGroup): bool
    {
        $rolesService = new NavigationRoleService;
        $roles = $rolesService->rolesNavigationFromSlugPolicy($this::SLUG_NAVIGATION_ITEMS, $this::UPDATE);

        return $user->hasAnyRole($roles);
    }

    /**
     * Determine whether the user can delete any model.
     */
    public function deleteAny(User $user): bool
    {

        $rolesService = new NavigationRoleService;
        $roles = $rolesService->rolesNavigationFromSlugPolicy($this::SLUG_NAVIGATION_ITEMS, $this::DELETEANY);

        return $user->hasAnyRole($roles);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, NavigationGroup $navigationGroup): bool
    {

        $rolesService = new NavigationRoleService;
        $roles = $rolesService->rolesNavigationFromSlugPolicy($this::SLUG_NAVIGATION_ITEMS, $this::DELETE);

        return $user->hasAnyRole($roles);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, NavigationGroup $navigationGroup): bool
    {

        $rolesService = new NavigationRoleService;
        $roles = $rolesService->rolesNavigationFromSlugPolicy($this::SLUG_NAVIGATION_ITEMS, $this::RESTORE);

        return $user->hasAnyRole($roles);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, NavigationGroup $navigationGroup): bool
    {

        $rolesService = new NavigationRoleService;
        $roles = $rolesService->rolesNavigationFromSlugPolicy($this::SLUG_NAVIGATION_ITEMS, $this::FORCEDELETE);

        return $user->hasAnyRole($roles);
    }
}
