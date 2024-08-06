<?php

namespace App\Services;
use App\Models\NavigationGroup;
use App\Models\NavigationItem;
use App\Models\ReductionField;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;

class NavigationService
{
    public function getNavigationGroupSlug($navigation_item_slug){
        return NavigationItem::where('slug', $navigation_item_slug)->first()->navigation_group->slug;
    }

    public function getNavigationSort($navigation_item_slug){
        return NavigationItem::where('slug', $navigation_item_slug)->first()->navigation_sort;
    }
}
