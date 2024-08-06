<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 *
 *
 * @property int $id
 * @property string $order_number
 * @property string $prefix
 * @property int $progressive
 * @property int $year
 * @property float $price
 * @property float $fee
 * @property float|null $duty_stamp
 * @property int $user_id
 * @property int $order_type_id
 * @property int $order_status_id
 * @property int|null $payment_id
 * @property int|null $cashier_id
 * @property int|null $company_id
 * @property string|null $email_to
 * @property int|null $email_sent
 * @property int $can_modify
 * @property int $print_at_home
 * @property string|null $printed_at
 * @property string|null $completed_at
 * @property string|null $deleted_at
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $printed_counter
 * @property-read \App\Models\Cashier|null $cashier
 * @property-read \App\Models\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Payment|null $payment
 * @property-read \App\Models\PaymentType|null $payment_type
 * @property-read \App\Models\Slot|null $slot
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCanModify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDutyStamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmailTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrintAtHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrintedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePrintedCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereProgressive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereYear($value)
 * @mixin \Eloquent
 */
class Order extends Model
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
        return $this->hasMany(OrderItem::class);
    }

}
