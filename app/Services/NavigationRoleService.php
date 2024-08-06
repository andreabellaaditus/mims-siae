<?php

namespace App\Services;

use App\Models\User;
use App\Models\NavigationItem;
use App\Models\NavigationGroup;
use Spatie\Permission\Models\Role;

class NavigationRoleService
{
    public function rolesNavigationFromSlugPolicy(string $slug, string $operations): mixed
    {
        // Se il flag groupException, che indica che comanda il valore presente su navigation_items, è a true
        // vengono presi i ruoli dalla tabella navigation_items
        // altrimenti quelli presenti nella tabella navigation_groups

        $navigationItem = NavigationItem::where('navigation_items.slug', $slug)
            ->where('navigation_items.active', 1)
            ->whereHas('navigation_group', function ($query) {
                $query->where('active', '=', 1);
            })
            ->first();

        if (isset($navigationItem)) {
            if ($navigationItem->groupException) {
                $rolesGroupItem = $navigationItem->roles;
            } else {
                $rolesGroupItem = $navigationItem->navigation_group->roles;
            }
        }

        $roles = [];
        if (isset($rolesGroupItem)) {
            foreach ($rolesGroupItem as $key => $value) {
                if (isset($value[$operations]) && $value[$operations]) {
                    array_push($roles, $key);
                }
            }
        }

        return $roles;
    }
}
