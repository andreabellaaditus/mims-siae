<?php

namespace App\Services;
use App\Models\OrderItemStatus;
use App\Models\ReductionField;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;

class OrderItemStatusService
{
    public function getPurchasedStatusId(){
        $status = OrderItemStatus::where('slug','purchased')->first();
        return $status->id;
    }

}
