<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Scopes\ActiveScope;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_category_id',
        'school_degree_id',
        'description',
        'site_id',
        'code',
        'name',
        'slug',
        'price_sale',
        'price_purchase',
        'price_web',
        'vat',
        'active',
        'is_purchasable',
        'is_date',
        'is_hour',
        'is_language',
        'is_pickup',
        'is_min_pax',
        'min_pax',
        'is_max_pax',
        'max_pax',
        'is_duration',
        'is_pending',
        'online_reservation_delay',
        'closing_reservation',
        'is_archived',
        'archived_at',
        'archived_by',
        'is_siae',
        'negozio_id'
    ];

    public function product_category() : BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function school_degree() : BelongsTo
    {
        return $this->belongsTo(SchoolDegree::class);
    }

    public function site() : BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function user_archived() : BelongsTo
    {
        return $this->belongsTo(User::class,'archived_by','id');
    }

    public function service_notifications() : HasMany
    {
        return $this->hasMany(ServiceNotification::class);
    }

    public function slots() : HasMany
    {
        return $this->hasMany(Slot::class);
    }

    public function scopeIsPurchasable($query)
    {
        return $query->where('is_purchasable',1);
    }

    public function scopeNotArchived($query)
    {
        return $query->where('is_archived', 0);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeTickets($query)
    {
        return $query->whereHas('product_category', function($product_category){
            $product_category->where('slug','tickets');
        });
    }
    protected static function booted(): void
    {
        static::addGlobalScope(new ActiveScope);
    }

    public function getRealMinPax($slot)
    {
        if($realMinPax = $this->min_pax ?? 0)
        {
            $cacheKey = 'service_'.$this->id.'_slot_'.$slot->format('Y-m-d H:i').'_min_pax';
            $cachedMinPax = Cache::get($cacheKey);
            if(isset($cachedMinPax)) {
                $realMinPax = $cachedMinPax;
            }

            if ($realMinPax)
            {
                Cache::forget($cacheKey);

                $realMinPax = Cache::remember($cacheKey, 60*24*30, function () use ($slot) {
                    $totalPax = OrderItem::whereHas('product', function($query) {
                        $query->where('service_id', $this->id);
                        })
                        ->whereHas('order.status', function($query) {
                            $query->where('code', '!=', 'deleted');
                        })
                        ->where('date_service', $slot->format('Y-m-d'))
                        ->where('hour_service', $slot->format('H:i:s'))
                        ->whereHas('order_item_status', function($query) {
                            $query->where('code', 'purchased');
                        })
                        ->sum('qty');

                    return ($this->min_pax > $totalPax) ? ($this->min_pax - $totalPax) : 0;
                });
            }
        }

        return $realMinPax;
    }


}
