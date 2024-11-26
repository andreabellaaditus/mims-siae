<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SiaeOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id',
        'order_number',
        'progressive',
        'price',
        'year',
        'order_type_id',
        'order_status_id',
        'payment_id',
        'cashier_id',
        'company_id',
        'printed_at',
        'prefix',
        'email_sent',
        'email_to',
        'user_id'
    ];
    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function payment_type(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function cashier(): BelongsTo
    {
        return $this->belongsTo(Cashier::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function items() {
        return $this->hasMany(SiaeOrderItem::class);
    }

}
