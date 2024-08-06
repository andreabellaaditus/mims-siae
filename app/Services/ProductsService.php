<?php

namespace App\Services;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;
use App\Models\ProductCategory;
use App\Models\Service;
use App\Models\Product;

class ProductsService
{

    public function getSalable($service_id, $type){

        return Product::select('id', 'name', 'price_sale', 'deliverable', 'is_siae', 'code', 'cod_ordine_posto')
        ->whereRaw('validity_from_issue_value IS NOT NULL')
        ->where('deliverable', 1)
        ->where('service_id', $service_id)->where('active', 1)
        ->whereHas('product_validities', function($query) {
            $query->whereDate('start_validity', '<=', Carbon::now()->format('Y-m-d'))
                ->where(function($query) {
                    $query->whereNull('end_validity')
                        ->orWhereDate('end_validity', '>=', Carbon::now()->format('Y-m-d'));
                });
        })
        ->whereJsonContains('sale_matrix->customers', [$type => true])
        ->get();
    }

    public function getBySite($product_id){
        $service = Service::find(session('service_id'));
        return Product::query()->join('services', 'services.id', 'products.service_id')->where('services.active', 1)
        ->where(['site_id' => $service->site_id, 'products.active' => 1])
        ->whereRaw('validity_from_issue_value IS NOT NULL')
        ->where('products.id', '!=', $product_id)
        ->whereHas('product_validities', function($query) {
            $query->whereDate('start_validity', '<=', Carbon::now()->format('Y-m-d'))
                ->where(function($query) {
                    $query->whereNull('end_validity')
                        ->orWhereDate('end_validity', '>=', Carbon::now()->format('Y-m-d'));
                });
        })
        ->withoutGlobalScope(ActiveScope::class)->pluck('products.name', 'products.id');
    }

}


