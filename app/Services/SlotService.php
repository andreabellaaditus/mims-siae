<?php

namespace App\Services;

use App\Enums\WeekDays;
use App\Models\SiaeOrderItem;
use App\Models\Slot;
use App\Models\SlotDay;
use App\Models\SiteHour;
use App\Models\ReductionField;
use App\Services\NotificationService;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;
use Illuminate\Support\Facades\DB;

class SlotService
{
    public function checkCorrectSlots($slots){
        $chosenDays = array();
        foreach($slots as $slot){
            if($slot['slot_type'] == 'repeated'){
                $chosenDays = array_merge ($chosenDays, $slot['slot_days']);
            }
        }
        if(count(array_unique($chosenDays)) < count($chosenDays)){

            return false;

        }else{
            return true;
        }

    }

    public function getSiteDays($get){
        $arr_selected = array();
        if($get('../../hours')){
            $workingHours = $get('../../hours');
            $existing = array_column($workingHours, 'day');
            foreach ($existing as $key => $repeater) {
                foreach ($existing[$key] as $existing_day) {
                    $arr_selected[] = $existing_day;
                }
            }
        }
        if (!empty($arr_selected)) {
            $days = SlotDay::whereNotIn("slug", $arr_selected)->pluck('name', 'slug');
        } else {
            $days = SlotDay::pluck('name', 'slug');
        }
        return $days;
    }


    public function getProductDays($get){
        $arr_selected = array();
        if($get('../../slots')){
            $workingHours = $get('../../slots');
            $existing = array_column($workingHours, 'slot_days');
            foreach ($existing as $key => $repeater) {
                foreach ($existing[$key] as $existing_day) {
                    $arr_selected[] = $existing_day;
                }
            }
        }
        if (!empty($arr_selected)) {
            $days = SlotDay::whereNotIn("slug", $arr_selected)->pluck('name', 'slug');
        } else {
            $days = SlotDay::pluck('name', 'slug');
        }
        return $days;
    }

    public function getSlots($field_name, $field_id, $date_service, $site_id) {
        $available_hours = array();
        if ($date_service) {
            $week_day = strtolower(date('D', strtotime($date_service)));
            $site_hours = SiteHour::where('site_id', $site_id)
                ->where('day', 'like', '%' . $week_day . '%')
                ->where('start_validity', '<=', $date_service)
                ->where('end_validity', '>=', $date_service)
                ->first();

            if ($site_hours) {
                $slots = Slot::where($field_name, $field_id)
                    ->where('slot_days', 'like', '%' . $week_day . '%')
                    ->first();

                if ($slots) {
                    if ($slots->slot_type == 'free') {
                        $hours = $slots->hours->toArray();
                        foreach ($hours as $key => $hour) {
                            $hour = date('H:i:s', strtotime($hour));
                            if (($hour > $site_hours->closing_ticket_office) || ($hour > $site_hours->break_start && $hour < $site_hours->break_end) || ($date_service == date('Y-m-d') && $hour < date('H:i:s'))) {
                                unset($hours[$key]);
                            } else {
                                $occupied_spots = SiaeOrderItem::join('products', 'siae_order_items.product_id', '=', 'products.id')
                                    ->where('siae_order_items.date_service', $date_service)
                                    ->where('siae_order_items.hour_service', $hour)
                                    ->where('siae_order_items.product_id', $field_id)
                                    ->where('products.exclude_slotcount', 0)
                                    ->whereHas('order_item_status', function($query) {
                                        $query->where('code', 'purchased');
                                    })
                                    ->sum('siae_order_items.qty');

                                $available_hours[$key]['time'] = Carbon::parse($hour)->format('H:i');
                                $available_hours[$key]['free_spots'] = $slots->availability - $occupied_spots;
                                $available_hours[$key]['desc'] = Carbon::parse($hour)->format('H:i') . " (" . ($slots->availability - $occupied_spots) . " " . __('orders.free-spots') . ")";
                            }
                        }
                    } else {
                        $time = Carbon::parse($site_hours->opening);
                        for ($time; $time->format('H:i') < $site_hours->closing_ticket_office; $time->addMinutes($slots->duration)) {
                            $formatted_time = $time->format('H:i:s');
                            if (($formatted_time < $site_hours->break_start || $formatted_time >= $site_hours->break_end) && ($date_service != date('Y-m-d') || $formatted_time > date('H:i:s'))) {
                                $occupied_spots = SiaeOrderItem::join('products', 'siae_order_items.product_id', '=', 'products.id')
                                    ->where('siae_order_items.date_service', $date_service)
                                    ->where('siae_order_items.hour_service', $formatted_time)
                                    ->where('siae_order_items.product_id', $field_id)
                                    ->where('products.exclude_slotcount', 0)
                                    ->whereHas('order_item_status', function($query) {
                                        $query->where('code', 'purchased');
                                    })
                                    ->sum('siae_order_items.qty');

                                $available_hours[] = [
                                    'time' => $time->format('H:i'),
                                    'free_spots' => $slots->availability - $occupied_spots,
                                    'desc' => $time->format('H:i') . " (" . ($slots->availability - $occupied_spots) . " " . __('orders.free-spots') . ")"
                                ];
                            }
                        }
                    }
                }
            }
        }
        return $available_hours;
    }

    public function checkAvailability($field_name, $field_id, $date_service, $hour_service, $site_id) {
        $free_spots = 0;

        if ($date_service && $hour_service) {
            $week_day = strtolower(date('D', strtotime($date_service)));
            $site_hours = SiteHour::where('site_id', $site_id)
                ->where('day', 'like', '%' . $week_day . '%')
                ->where('start_validity', '<=', $date_service)
                ->where('end_validity', '>=', $date_service)
                ->first();
            if ($site_hours) {
                $slots = Slot::where($field_name, $field_id)
                    ->where('slot_days', 'like', '%' . $week_day . '%')
                    ->first();

                if ($slots) {
                    $hour_service = date('H:i:s', strtotime($hour_service));

                    if (($hour_service < $site_hours->closing_ticket_office) && ($hour_service >= $site_hours->opening) &&
                        ($hour_service < $site_hours->break_start || $hour_service >= $site_hours->break_end) &&
                        ($date_service != date('Y-m-d') || $hour_service > date('H:i:s'))) {

                        $occupied_spots = SiaeOrderItem::join('products', 'siae_order_items.product_id', '=', 'products.id')
                            ->where('siae_order_items.date_service', $date_service)
                            ->where('siae_order_items.hour_service', $hour_service)
                            ->where('siae_order_items.product_id', $field_id)
                            ->where('products.exclude_slotcount', 0)
                            ->sum('siae_order_items.qty');

                        $free_spots = $slots->availability - $occupied_spots;
                    }
                }
            }
        }

        return $free_spots;
    }



}
