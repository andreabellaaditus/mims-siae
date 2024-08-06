<?php

namespace App\Services;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;
use App\Models\ProductCategory;
use App\Models\Service;
use App\Models\Product;

class ProductCategoryService
{

    public function getBySite($site_id){

        return
        ProductCategory::select()
            ->whereExists(Service::select()
                    ->whereColumn('product_categories.id', 'services.product_category_id')
                    ->where('services.site_id', $site_id)
                        ->whereExists(Product::select()
                        ->whereColumn('services.id', 'products.service_id'))
            )
            ->get();

    }

}
