<?php

namespace App\Services;
use App\Models\Product;
use App\Models\Service;
use App\Models\ProductCategory;
use App\Models\ReductionField;
use App\Models\SiaeProductHolder;
use App\Models\VirtualStoreSetting;
use App\Http\Helpers\Functions;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;

class ProductService
{

    public function __construct(
        protected Product $product,
    ){}

    public function getValidity()
    {
        $validUntil = Carbon::now('Europe/Rome');
        $validity_from_issue_unit = $this->product->validity_from_issue_unit->value;
        $validity_from_issue_value = $this->product->validity_from_issue_value;

        if (isset($validity_from_issue_unit) && isset($validity_from_issue_value))
        {
            switch ($validity_from_issue_unit) {
                case "days":
                    $validUntil->addDays($validity_from_issue_value);
                    break;
                case "weeks":
                    $validUntil->addWeeks($validity_from_issue_value);
                    break;
                case "months":
                    $validUntil->addMonths($validity_from_issue_value);
                    break;
                case "years":
                    $validUntil->addYears($validity_from_issue_value);
                    break;
            }
        } else{
            $validUntil->addMonths(6);
        }

        return $validUntil;
    }

    public function getExpiration()
    {
        $validUntil = Carbon::now('Europe/Rome');
        $validity_from_burn_unit = $this->product->validity_from_burn_unit->value;
        $validity_from_burn_value = $this->product->validity_from_burn_value;

        if (isset($validity_from_burn_unit) && isset($validity_from_burn_value))
        {
            switch ($validity_from_burn_unit) {
                case "days":
                    $validUntil->addDays($validity_from_burn_value);
                    break;
                case "weeks":
                    $validUntil->addWeeks($validity_from_burn_value);
                    break;
                case "months":
                    $validUntil->addMonths($validity_from_burn_value);
                    break;
                case "years":
                    $validUntil->addYears($validity_from_burn_value);
                    break;
            }
        } else{
            $validUntil->addMonths(6);
        }

        return $validUntil;
    }


    public function getValidityDays()
    {
        $validUntil = Carbon::now('Europe/Rome');
        $validity_from_burn_unit = $this->product->validity_from_burn_unit->value;
        $validity_from_burn_value = $this->product->validity_from_burn_value;

        if (isset($validity_from_burn_unit) && isset($validity_from_burn_value))
        {
            switch ($validity_from_burn_unit) {
                case "days":
                    return $validity_from_burn_value;
                case "weeks":
                    return $validity_from_burn_value * 7;
                case "months":
                    return $validity_from_burn_value * 30;
                case "years":
                    return $validity_from_burn_value * 365;
            }
        } else{
            return 180;
        }

        return $validUntil;
    }

    public function getReductionFields()
    {
        $product_id = $this->product->id;

        return ReductionField::query()
            ->join('product_reduction_fields', 'reduction_fields.id', '=', 'product_reduction_fields.reduction_field_id')
            ->join('product_reductions', 'product_reduction_fields.product_id', '=', 'product_reductions.product_id')
            ->join('products', 'products.id', '=', 'product_reductions.product_id')
            ->where('products.check_document', 1)
            ->where('reduction_fields.active', 1)
            ->where('product_reduction_fields.product_id', $product_id)
            ->withoutGlobalScope(ActiveScope::class)
            ->select('reduction_fields.name','reduction_fields.id', 'product_reductions.reduction_id', 'product_reduction_fields.reduction_field_id')
            ->get()->keyBy('id')->toArray();

    }


    public function getCartProducts($user_id, $site_id){

        return Product::query()
        ->join('services', 'products.service_id', '=', 'services.id')->where('site_id', $site_id)
        ->join('cart_products', 'products.id', '=', 'cart_products.product_id')
        ->join('carts', 'carts.id', '=', 'cart_products.cart_id')->where('user_id', $user_id)
            ->selectRaw('products.matrix_generation_type, products.service_id, products.service_id, products.check_document, products.is_name, products.validity_from_issue_unit, products.validity_from_issue_value, cart_products.is_cumulative,
            cart_products.cart_id, cart_products.date_service, cart_products.hour_service, products.has_additional_code, products.is_hour, products.is_date,
            cart_products.open_ticket, products.id, products.vat, products.name, price_sale, COUNT(cart_products.product_id) as qty,
            (price_sale * COUNT(cart_products.product_id)) as total')
            ->groupBy('cart_products.product_id')
            ->groupBy('cart_products.date_service')
            ->groupBy('cart_products.hour_service')
            ->groupBy('cart_products.open_ticket')
            ->groupBy('cart_products.is_cumulative')
            ->groupBy('cart_products.cart_id')
            ->withoutGlobalScope(ActiveScope::class)
            ->where('products.active', 1)
            ->orderByRaw('cart_products.product_id')->get();

    }

    public function getIsDeliverable(){
        return Product::select('deliverable')->where('id', $this->product->id)->first();
    }

    public function getProductCategoryType(){
        $service_id = $this->product->service_id;

        $service = Service::where('id', $service_id)->first();
        $prod_cat = ProductCategory::where('id', $service->product_category_id)->first();
        return $prod_cat;

    }


    public function createVirtualStoreSettingsRelationShip($ticketType)
{
    $service = $this->product->service;

    if ($service->product_category->slug == "tickets" || $service->product_category->slug == "site-events") {
        switch ($ticketType) {
            case 'INT':
                $productType = 'Intero';
                break;
            case 'RID':
                $productType = 'Ridotto';
                break;
            case 'GRA':
                $productType = 'Gratuito';
                break;
            case 'CIN':
                $productType = 'Cumulativo Intero';
                break;
            case 'CRI':
                $productType = 'Cumulativo Ridotto';
                break;
            default:
                $productType = $ticketType;
                $ticketType = strtoupper(substr(str_replace(" ", "", $ticketType), 0, 3));
                break;
        }

        $name = sprintf('Prefisso Matricola Biglietto %s %s', $productType, ucwords(str_replace('-', ' ', $service->site->slug)));
        $key = Functions::getValidFileName(sprintf('%s %s', $productType, $service->site->slug));

        $matrixPrefix = $ticketType . '/' . $service->site->matrix_suffix;

        VirtualStoreSetting::firstOrCreate(
            ['product_id' => $this->product->id],
            [
                'key' => $key,
                'name' => $name,
                'description' => 'Prefisso da inserire prima del codice numerico all\'interno del numero di matricola',
                'value' => $matrixPrefix,
                'active' => 1
            ]
        );

    }
}

}
