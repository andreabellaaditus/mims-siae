<?php

namespace App\Models;

use App\Enums\ValidityPeriod;
use App\Enums\MatrixGenerationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use App\Models\Scopes\ActiveScope;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'has_supplier',
        'supplier_id',
        'product_subcategory_id',
        'active',
        'code',
        'article',
        'name',
        'slug',
        'price_sale',
        'price_purchase',
        'price_web',
        'vat',
        'price_per_pax',
        'num_pax',
        'check_document',
        'printable',
        'deliverable',
        'billable',
        'is_date',
        'is_hour',
        'is_name',
        'is_card',
        'is_cumulative',
        'is_link',
        'product_link',
        'matrix_generation_type',
        'validity_from_issue_unit',
        'validity_from_issue_value',
        'validity_from_burn_unit',
        'validity_from_burn_value',
        'max_scans',
        'has_additional_code',
        'qr_code',
        'online_reservation_delay',
        'notes',
        'sale_matrix',
        'is_siae',
        'exclude_slotcount',
        'cod_ordine_posto',
        'cod_riduzione_siae',
        'date_event'
    ];

    protected $casts = [
        'matrix_generation_type' => MatrixGenerationType::class,
        'validity_from_issue_unit' => ValidityPeriod::class,
        'validity_from_burn_unit' => ValidityPeriod::class,
        'sale_matrix' => AsArrayObject::class,

    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope);
    }
    public function product_subcategory() : BelongsTo
    {
        return $this->belongsTo(ProductSubcategory::class);
    }

    public function service() : BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function supplier() : BelongsTo
    {
        return $this->belongsTo(User::class,'supplier_id', 'id');
    }

    public function virtual_store_settings() : BelongsTo
    {
        return $this->belongsTo(VirtualStoreSetting::class, 'id', 'product_id');
    }

    public function reductions() : belongsToMany
    {
        return $this->belongsToMany(Reduction::class, 'product_reductions', 'product_id', 'reduction_id');
    }

    public function related_products() : belongsToMany
    {
        return $this->belongsToMany(Product::class, 'related_products', 'main_product_id', 'product_id');
    }

    public function reduction_fields() : belongsToMany
    {
        //return $this->hasManyThrough(ReductionField::class, ProductReductionField::class, 'product_id', 'id', 'id', 'reduction_field_id');
        return $this->belongsToMany(ReductionField::class, 'product_reduction_fields', 'product_id', 'reduction_field_id');

    }

    public function sites() : belongsToMany
    {
        return $this->belongsToMany(Site::class, 'product_cumulatives', 'product_id', 'site_id')->orderBy('id', 'asc');
        //return $this->belongsToMany(ProductCumulative::class);
    }

    public function product_cumulatives() : HasMany
    {
        return $this->hasMany(ProductCumulative::class)->orderBy('id', 'asc');
    }

    public function slots() : HasMany
    {
        return $this->hasMany(Slot::class);
    }

    public function product_validities() : HasMany
    {
        return $this->hasMany(ProductValidity::class);
    }


    public function getRealMinPax($slot)
    {
        if($realMinPax = $this->service->min_pax ?? 0)
        {
            $cacheKey = 'product_'.$this->id.'_slot_'.$slot->format('Y-m-d H:i').'_min_pax';
            $cachedMinPax = Cache::get($cacheKey);
            if(isset($cachedMinPax)) {
                $realMinPax = $cachedMinPax;
            }

            if ($realMinPax)
            {
                Cache::forget($cacheKey);

                $realMinPax = Cache::remember($cacheKey, 60*24*30, function () use ($slot) {
                    $totalPax = OrderItem::where('product_id', $this->id)
                        ->whereHas('order.status', function($query) {
                            $query->where('code', '!=', 'deleted');
                        })
                        ->where('date_service', $slot->format('Y-m-d'))
                        ->where('hour_service', $slot->format('H:i:s'))
                        ->whereHas('order_item_status', function($query) {
                            $query->where('code', 'purchased');
                        })
                        ->sum('qty');

                    return ($this->service->min_pax > $totalPax) ? ($this->service->min_pax - $totalPax) : 0;
                });
            }
        }

        return $realMinPax;
    }

}
