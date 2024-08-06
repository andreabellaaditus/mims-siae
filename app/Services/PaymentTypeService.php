<?php

namespace App\Services;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;
use App\Models\Payment;
use App\Models\PaymentType;

class PaymentTypeService
{

    public function getTypeSlug($payment_type_id){
        return PaymentType::select('slug')->where('id', $payment_type_id)->first();
    }
}
