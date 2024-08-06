<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Cashier;
use App\Models\User;
use App\Models\Site;

class CashierRegisterClosure extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cashier_id', 'cashier_detail', 'user_id',
        'date','opened_at','closed_at',
        'opening_cash_amount_last_closure', 'opening_cash_amount_registered', 'opening_stock_check_passed', 'opening_stock_check_values',
        'closure_cash_amount_calculated', 'closure_paid_amount_calculated', 'closure_pos_amount_calculated', 'closure_voucher_amount_calculated', 'closure_stripe_amount_calculated', 'closure_bank_amount_calculated',
        'closure_cash_amount_registered', 'closure_paid_amount_registered', 'closure_pos_amount_registered', 'closure_voucher_amount_registered',
        'closure_stripe_amount_accounted', 'closure_bank_amount_accounted', 'closure_stock_check_passed', 'closure_stock_check_values',
        'closed_at', 'closure_notes', 'opening_notes',
        'closure_paid_amount_receipt', 'closure_pos_amount_receipt',
        'verified', 'verified_at', 'safe_id',
        'cash_deposit_id'

    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    protected $appends = [

    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cashier(){
        return $this->belongsTo(Cashier::class);
    }

    public function safe(){
        return $this->belongsTo(Safe::class);
    }

}



