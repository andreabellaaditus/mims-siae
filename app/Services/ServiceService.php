<?php

namespace App\Services;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;
use App\Models\ProductCategory;
use App\Models\Service;
use App\Models\Product;
use App\Services\ProductsService;
use Illuminate\Database\Eloquent\Builder;

class ServiceService
{


    public function getByProductCategoryAndSite($product_category_id, $site_id){

        $services = Service::select()->where('product_category_id', $product_category_id)
        ->where('site_id', $site_id)->get();

        return $services;
    }

}
