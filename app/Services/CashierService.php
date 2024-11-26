<?php

namespace App\Services;
use App\Models\Cashier;
use App\Models\CashierRegisterClosure;
use App\Models\CashierActive;
use App\Models\Site;
use App\Models\SiaeOrderItem;
use App\Models\OrderStatus;
use App\Models\OrderItemStatus;
use App\Services\OrderService;
use App\Http\Helpers\Functions;
use App\Http\Helpers\GoogleDriveHelper;
use App\Services\OrderStatusService;
use App\Services\OrderItemStatusService;
use App\Models\ReductionField;
use Carbon\Carbon;
use App\Models\Scopes\ActiveScope;
use App\Models\UserSite;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CashierService
{

    public function getForSelect($site_id){
        $existingCashiers = CashierActive::pluck('cashier_id')->toArray();

        return Cashier::query()
            ->whereNotIn('id', $existingCashiers)
            ->where('site_id', $site_id)
            ->pluck('name', 'id');
    }


    public function getCashAmountLastClosure($cashier_id){
        if($cashier_id != null){

            $res = CashierRegisterClosure::where('cashier_id', '=', $cashier_id)
            ->orderBy('date', 'desc')
            ->orderBy('closed_at', 'desc')
            ->first();

            if($res){
                return $res->closure_cash_amount_registered;
            }else{
                return 0;
            }
        }

    }


    public function getCashFund($cashier_id){

        $res = Cashier::where('id', '=', $cashier_id)
        ->select('cashfund')
        ->first();

        if($res){
            return $res->cashfund;
        }else{
            return 0;
        }


    }

    static function isFreeCashDesk($user, $cashDeskId)
    {
        $date = Carbon::now()->subMinutes(Config::get('session.lifetime'));

        $freeCashDesk = CashierActive::where('user_id', '<>', $user->id)
            ->where('cashier_id', $cashDeskId)
            ->where('updated_at', '>=', $date)
            ->first();

        return $freeCashDesk instanceof CashierActive ? $freeCashDesk : false;
    }

    static function addActivityCashDesk($user, $cashDeskId)
    {
        $newActiveOperator = CashierActive::where('user_id', $user->id)->first();

        if (!$newActiveOperator instanceof CashierActive) {
            $newActiveOperator = new CashierActive();
        }
        $newActiveOperator->user_id = $user->id;
        $newActiveOperator->cashier_id = $cashDeskId;
        $newActiveOperator->updated_at = Carbon::now();
        $newActiveOperator->save();

    }

    public function checkAndAddCashDesk($user, $cashDeskId, $add = false)
    {

        $response = self::isFreeCashDesk($user, $cashDeskId);

        if ($response) {
            return $response;
        } else {
            self::addActivityCashDesk($user, $cashDeskId);
        }

        return false;
    }

    public function hasOpenDesk($current_user_id, $site_id){
        return CashierActive::join('cashiers', 'cashiers.id', 'cashiers_active.cashier_id')->where(['user_id' => $current_user_id, 'cashiers.site_id' => $site_id ])
        ->count();
    }


    public function hasAnotherSiteOpen($current_user_id, $site_id)
    {
        return CashierActive::join('cashiers', 'cashiers.id', '=', 'cashiers_active.cashier_id')
            ->where('user_id', $current_user_id)
            ->where('cashiers.site_id', '<>', $site_id) // Modificato per essere diverso
            ->count();
    }


    public function hasAnotherOpenDesk($current_user_id){

        return CashierActive::where('user_id', $current_user_id)
        ->count();

    }

    public function isOpenDesk($cashier_id){

        return CashierActive::where('cashier_id', $cashier_id)
        ->count();

    }

    public function checkCashierRegisterClosureExists($cashierId, $current_user_id){

        return CashierRegisterClosure::where('user_id', '=', $current_user_id)
            ->where('date', '=', date('Y-m-d'))
            ->where('cashier_id', '=', $cashierId)
            ->whereNull('closed_at')
            ->count();

    }

    public function getWithSite($cashierId){
        return Cashier::with('site')->find($cashierId);
    }

    public function createCashierRegisterClosure($data){
        return CashierRegisterClosure::create($data);
    }

    public function setCurrentCashierSession($site, $value)
    {
        $currentCashierSessionKey = $this->getCurrentCashierSessionKey($site);
        session()->put($currentCashierSessionKey,$value);
    }

    public function getAmountLastClosure($cashier_id){
        if($cashier_id != null){

            $res = CashierRegisterClosure::where('cashier_id', '=', $cashier_id)
            ->orderBy('date', 'desc')
            ->orderBy('closed_at', 'desc')
            ->first();

            if($res){
                return $res->closure_cash_amount_registered;
            }else{
                return 0.00;
            }

        }

    }

    public function getCashiersBySite($site_id){
        return UserSite::join('users', 'users.id', 'user_sites.user_id')
        ->whereJsonContains('site_id', [$site_id])->pluck('users.name', 'user_id');
    }

    private function getCurrentCashierSessionKey($site_id)
    {
        return 'currentCashierId_' . $site_id;
    }
    public function getCurrentCashierSession($site)
    {
        $currentCashierSessionKey = $this->getCurrentCashierSessionKey($site);
        $currentCashierSessionId = session()->get($currentCashierSessionKey);

        if(! $currentCashierSessionId){
            $openCashier = self::getOpenCashier($site);
            if($openCashier){
                self::setCurrentCashierSession($site, $openCashier->cashier_id);
            }
        }

        return session()->get($currentCashierSessionKey);
    }

    public function getOpenCashier($site)
    {
        $openCashier = $this->getLatestCashierRegisterClosure($site);
        return $openCashier ? $openCashier : null;
    }

    public function getLatestCashierRegisterClosure($site)
    {
        $orderService = new OrderService;
        $currentUser = $orderService->getCurrentUser($site);
        $openCashier = CashierRegisterClosure::join('cashiers', 'cashiers.id', 'cashier_register_closures.cashier_id')
        ->where('user_id', '=', $currentUser->id)->where('cashiers.site_id', $site)->whereNull('closed_at')->first();
        return $openCashier;
    }



    public function getClosureByCashier($siteId){

        $cashierId = self::getCurrentCashierSession($siteId);
        $closureCashAmountRegistered = 0;
        $closureCashFund = 0;
        $stockList = [];

        $currentCashClosurePayments = [];

        try {
            $site = Site::find($siteId);

            $orderService = new OrderService;
            $site_id = session('site_id');
            $user = $orderService->getCurrentUser($site_id);
            $userId = $user->id;

            if (!$cashierId) {
                throw new \Exception(__('orders.cashier.no-cashier-selected'));
            }

            $currentCashClosure = CashierRegisterClosure::where('cashier_id', '=', $cashierId)
                ->whereNull('closed_at')
                ->orderBy('date', 'desc')
                ->first();
            if ($currentCashClosure) {
                $closureCashAmountRegistered = $currentCashClosure->closure_cash_amount_registered;

                $openingTime = Carbon::parse($currentCashClosure->date)->setTimeFromTimeString($currentCashClosure->opened_at);
                $orderStatusService = new OrderStatusService;
                $orderItemStatusService = new OrderItemStatusService;
                $completedStatusId = $orderStatusService->getCompletedStatusId();
                $purchasedStatusId = $orderItemStatusService->getPurchasedStatusId();

                $currentCashClosurePaymentRecap =
                SiaeOrderItem::selectRaw('case when payments.gateway = "pos" then "credit_card" else payments.gateway end as gateway, sum(siae_order_items.price) as total')
                    ->leftJoin('siae_orders', 'siae_order_items.siae_order_id', '=', 'siae_orders.id')
                    ->leftJoin('payments', 'siae_orders.payment_id', '=', 'payments.id')
                    ->leftJoin('cashiers', 'siae_orders.cashier_id', '=', 'cashiers.id')
                    ->where('cashiers.site_id', $site_id)
                    ->where('siae_orders.cashier_id', '=', $cashierId)
                    ->where('siae_orders.user_id', '=', $userId)
                    ->where('siae_orders.order_status_id', '=', $completedStatusId)
                    ->where('siae_orders.created_at', '>=', $openingTime->format('Y-m-d H:i:s'))
                    ->where('siae_order_items.order_item_status_id', '=', $purchasedStatusId)
                    ->groupBy(DB::raw("case when payments.gateway = 'pos' then 'credit_card' else payments.gateway end"));

                $currentCashClosurePaymentRecap = $currentCashClosurePaymentRecap->get();

                foreach ($currentCashClosurePaymentRecap as $currentCashClosurePayment) {
                    $currentCashClosurePayments[$currentCashClosurePayment->gateway] = number_format($currentCashClosurePayment->total, 2, '.', '');
                }

                $closureCashAmountRegistered = $currentCashClosure->opening_cash_amount_registered;

                //$stockList = $this->_getStockInfo($siteId, $cashierId);
            } else {
                $status = 'error';
                $title = __('global.warning');
                $message = __('orders.cashier.no-closable');
            }
        } catch (\Exception $e) {
            $status = 'error';
            $title = __('global.warning');
            $message = $e->getMessage();
        }

        $response = [
            'openingCashAmountRegistered' => number_format($closureCashAmountRegistered, 2, '.', ''),
            'cashFund' => number_format($closureCashFund, 2, '.', ''),
            'currentCashClosurePayments' => $currentCashClosurePayments,
            //'stocks' => $stockList,
        ];
        return $response;
    }

    public function getCashierRegisterClosure($closureId)
    {
        $cashierRegisterClosure = CashierRegisterClosure::with(['user', 'cashier', 'cashier.site'])
            ->find($closureId);
        return $cashierRegisterClosure;
    }

    public function saveOnsiteClosure($closureId, $data, $closureStatus = null, $currentUser = null)
    {
        $status = 'error';
        $title = '';
        $message = '';
        $color = 'success';
        $icon = 'heroicon-m-check-circle';

        try {

            $now = Carbon::now();

            $cashierRegisterClosure = $this->getCashierRegisterClosure($closureId);

            $cashierRegisterClosure->closure_notes = isset($data['closure_notes']) ? $data['closure_notes'] : null;

            $user = $currentUser ? $currentUser : auth()->user();

            $cashierRegisterClosure->closure_hand_amount_to = isset($data['closure_hand_amount_to']) ? $data['closure_hand_amount_to'] : null;
            $cashierRegisterClosure->closure_cash_amount_calculated = isset($data['closure_cash_amount_calculated']) ? $data['closure_cash_amount_calculated'] : null;
            $cashierRegisterClosure->closure_pos_amount_calculated = isset($data['closure_pos_amount_calculated']) ? $data['closure_pos_amount_calculated'] : null;
            $cashierRegisterClosure->closure_voucher_amount_calculated = isset($data['closure_voucher_amount_calculated']) ? $data['closure_voucher_amount_calculated'] : null;
            $cashierRegisterClosure->closure_paid_amount_calculated = isset($data['closure_paid_amount_calculated']) ? $data['closure_paid_amount_calculated'] : null;

            $cashierRegisterClosure->closure_cash_amount_registered = isset($data['closure_cash_amount_registered']) ? $data['closure_cash_amount_registered'] : null;
            $cashierRegisterClosure->closure_pos_amount_registered = isset($data['closure_pos_amount_registered']) ? $data['closure_pos_amount_registered'] : null;
            $cashierRegisterClosure->closure_voucher_amount_registered = isset($data['closure_voucher_amount_registered']) ? $data['closure_voucher_amount_registered'] : null;
            $cashierRegisterClosure->closure_paid_amount_registered = isset($data['closure_paid_amount_registered']) ? $data['closure_paid_amount_registered'] : null;
            $cashierRegisterClosure->closure_hand_amount_registered = isset($data['closure_hand_amount_registered']) ? $data['closure_hand_amount_registered'] : null;

            $cashierRegisterClosure->closure_hand_amount_registered = isset($data['closure_hand_amount_registered']) ? $data['closure_hand_amount_registered'] : null;
            $cashierRegisterClosure->closure_hand_amount_registered = isset($data['closure_hand_amount_registered']) ? $data['closure_hand_amount_registered'] : null;
            $cashierRegisterClosure->closure_hand_amount_registered = isset($data['closure_hand_amount_registered']) ? $data['closure_hand_amount_registered'] : null;

            $cashierRegisterClosure->closure_pos_amount_receipt = isset($data['closure_pos_amount_receipt']) ? $data['closure_pos_amount_receipt'] : null;
            $cashierRegisterClosure->closure_paid_amount_receipt = isset($data['closure_paid_amount_receipt']) ? $data['closure_paid_amount_receipt'] : null;
            $cashierRegisterClosure->closure_hand_amount_receipt = isset($data['closure_hand_amount_receipt']) ? $data['closure_hand_amount_receipt'] : null;
            $cashierRegisterClosure->safe_id = isset($data['safe_id']) ? $data['safe_id'] : null;


            if ($user->id == $cashierRegisterClosure->user_id) {

                if ($closureStatus == 'closed') {

                    $cashierRegisterClosure->closed_at = $now->format('H:i:s');

                    //$closingStockCheck = $this->chekStockQuantity($request, 'opening');

                    //$cashierRegisterClosure->closure_stock_check_passed = $closingStockCheck->passed;
                    //$cashierRegisterClosure->closure_stock_check_values = $closingStockCheck->values;

                    $status = 'success';
                    $title = __('orders.cashier-saved-successfully.title');
                    $message = __('orders.cashier-saved-successfully.message');

                }

            } else {

                $cashierRegisterClosure->opening_cash_amount_last_closure = isset($data['opening_cash_amount_last_closure']) ? $data['opening_cash_amount_last_closure'] : null;
                $cashierRegisterClosure->opening_cash_amount_registered = isset($data['opening_cash_amount_registered']) ? $data['opening_cash_amount_registered'] : null;

                $cashierRegisterClosure->closure_cash_amount_accounted = isset($data['closure_cash_amount_accounted']) ? $data['closure_cash_amount_accounted'] : null;
                $cashierRegisterClosure->closure_pos_amount_accounted = isset($data['closure_pos_amount_accounted']) ? $data['closure_pos_amount_accounted'] : null;
                $cashierRegisterClosure->closure_voucher_amount_accounted = isset($data['closure_voucher_amount_accounted']) ? $data['closure_voucher_amount_accounted'] : null;
                $cashierRegisterClosure->closure_paid_amount_accounted = isset($data['closure_paid_amount_accounted']) ? $data['closure_paid_amount_accounted'] : null;

                $cashierRegisterClosure->closure_hand_amount_accounted = isset($data['closure_hand_amount_accounted']) ? $data['closure_hand_amount_accounted'] : null;
                if ($closureStatus == 'verified') {
                    $cashierRegisterClosure->verified = true;
                    $cashierRegisterClosure->verified_at = $now->format('Y-m-d H:i:s');
                    $cashierRegisterClosure->verified_by = $user->id;

                    $status = 'success';
                    $title = __('orders.confirmed-successfully.title');
                    $message = __('orders.confirmed-successfully.message');

                } else {
                    $status = 'success';
                    $title = __('orders.saved-successfully.title');
                    $message = __('orders.saved-successfully.message');
                }
            }

            $cashierRegisterClosure->save();

        } catch (\Exception $e) {
            $status = 'error';
            $title = __('orders.generic-error.title');
            $message = __('orders.generic-error.message');
            $icon = 'heroicon-m-x-circle';
            $color = 'danger';

        }

        try {

            if (isset($closurePaidAmountReceiptUrl)) {
                $cashierRegisterClosure->closure_paid_amount_receipt = $closurePaidAmountReceiptUrl;
            }

            if (isset($closurePosAmountReceiptUrl)) {
                $cashierRegisterClosure->closure_pos_amount_receipt = $closurePosAmountReceiptUrl;
            }

            if (isset($closureHandAmountReceiptUrl)) {
                $cashierRegisterClosure->closure_hand_amount_receipt = $closureHandAmountReceiptUrl;
            }

            $cashierRegisterClosure->save();

        } catch (\Exception $e) {
            $status = 'error';
            $title = __('orders.cash_closure.receipt_error.title');
            $message = __('orders.receipt_error.message');
            $icon = 'heroicon-m-x-circle';
            $color = 'danger';
        }

        CashierActive::where('user_id', $currentUser->id)->delete();

        $response = new \StdClass();
        $response->status = $status;
        $response->title = $title;
        $response->message = $message;
        $response->color = $color;
        $response->icon = $icon;

        return $response;

    }


}
