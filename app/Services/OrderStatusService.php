<?php

namespace App\Services;
use App\Models\OrderStatus;
use App\Models\ReductionField;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;

class OrderStatusService
{

    public function getCompletedStatusId() {
        $status = OrderStatus::where("slug", "completed")->first();
        return $status->id;
    }

}
