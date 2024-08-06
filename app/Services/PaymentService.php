<?php

namespace App\Services;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Services\PaymentTypeService;

class PaymentService
{

    public function create($payment_type_id, $tot_price){

        $paymentTypeService = new PaymentTypeService();
        $dataPayment = [
            'code' => $paymentTypeService->getTypeSlug($payment_type_id)->slug,
            'gateway' => $paymentTypeService->getTypeSlug($payment_type_id)->slug,
            'total' => $tot_price,
            'fee' => 0,
            'payment_type_id' => $payment_type_id
        ];
        return Payment::create($dataPayment);

    }


    public function update($conditions, $data){

        return Payment::where($conditions)->update($data);

    }


}
