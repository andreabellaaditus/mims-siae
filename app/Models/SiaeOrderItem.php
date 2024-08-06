<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiaeOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'siae_order_id',
        'product_id',
        'user_id',
        'qty',
        'date_service',
        'hour_service',
        'price',
        'order_item_status_id',
        'payment_id',
        'validity',
        'is_cumulative',
        'printable_qr_code',
    ];

    public function payment_type(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }


    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function order_item_status() {
        return $this->belongsTo(OrderItemStatus::class);
    }

    public function order_item_reductions() {
        return $this->hasMany(SiaeOrderItemReduction::class);
    }

    public function scans() {
        return $this->hasMany(SiaeScan::class);
    }

    public function product_holder()
    {
        return $this->hasOne(SiaeProductHolder::class);
    }

    public function product_holders()
    {
        return $this->hasMany(SiaeProductHolder::class);
    }

    public function scanned_tickets(){
        return $this->hasMany(SiaeScan::class)->where("is_scanned", ">", 0);
    }

    public function order() {
        return $this->belongsTo(SiaeOrder::class, 'siae_order_id', 'id');
    }


}
