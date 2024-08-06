<?php

namespace App\Http\Helpers;

use App\Models\Product;
use App\Models\SiaeOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DeepCopy\f001\A;
use DB;
use Image;
use Storage;
use Mail;
use QrCode;

class Functions
{
    const FULL_DATE_FORMAT = 'd/m/Y';
    const FULL_TIME_FORMAT = 'H:i';

    public static function generateQrCodeHash($productId, $matrixId, $length = 16)
    {
        $ip = self::getClientIP();
        $product = Product::find($productId);
        if ($product instanceof Product && $product->qr_code) {
            return $product->qr_code;
        }

        $hash_code = md5($productId . "/" . $matrixId . "/" . microtime() . $ip);

        return $length < 32 ? substr($hash_code, 0, $length) : $hash_code;
    }

    public static function getClientIP()
    {
        return $_SERVER["HTTP_X_FORWARDED_FOR"] ?? $_SERVER["HTTP_CLIENT_IP"] ?? $_SERVER["REMOTE_ADDR"] ?? getenv('HTTP_X_FORWARDED_FOR') ?? getenv('HTTP_CLIENT_IP') ?? getenv('REMOTE_ADDR') ?? '127.0.0.1';
    }

    static function getFullOrderInformations($order_id)
    {
        return SiaeOrder::with('items', 'items.product', 'items.product.service.product_category', 'items.scans', 'items.scans.order_item.order_item_reductions', 'items.scans.virtual_store_matrix', 'items.product.service', 'items.product.service.site'/*, 'items.product.site.site.brochures'*/)->find($order_id);
    }

    static function getMatrixAttribute($item)
    {
        if ($item->product->service->product_category->slug == "tickets" || $item->product->service->product_category->slug == "site-events") {
            $arr_scans = [];
            foreach ($item->scans as $scan) {
                $type = $scan->virtual_store_matrix->code;
                $year = $scan->virtual_store_matrix->year;
                $arr_scans[] = $scan->virtual_store_matrix->progressive * 1;
            }
            if ($count = count($arr_scans)) {
                sort($arr_scans);
                return $type . "." . $arr_scans[0] . ($count > 1 ? "/" . $arr_scans[$count - 1] : "") . "." . $year;
            }
        }
        return "";
    }

    public static function collectTicketLayoutInfo($order, $item, $scan = null)
    {
        $slot = $item->date_service ? Carbon::parse($item->date_service) : null;
        if ($slot && $item->hour_service && $item->hour_service != '00:00:00') {
            $slot->setTimeFromTimeString($item->hour_service);
        } elseif ($slot)  {
            $now = Carbon::now();
            $slot->setTimeFromTimeString($now->toTimeString());
        }

        $qrCode = $scan ? $scan->qr_code : $item->printable_qr_code;
        $productName = $item->product->name;

        $expireDate = $scan ? $scan->date_expiration : $item->validity;
        $matrix = $scan ? $scan->virtual_store_matrix->code . "." . ($scan->virtual_store_matrix->progressive * 1) . "." . $scan->virtual_store_matrix->year :
                  self::getMatrixAttribute($item);

        $price = isset($item->promo_id) && $item->promo_id > 0 ? $item->price : $item->product->price_sale;

        foreach($item->product->related_products as $related_prod){
            $productName.= " + ".$related_prod->name;
            $price+= $related_prod->price_sale;
        }

        $ticketInfo = (object)[
            'siteName' => $item->product->service->site->name,
            'productName' => $productName,
            'matrix' => $matrix,
            'quantity' => $scan ? 1 : $item->qty,
            'priceSale' => number_format($price, 2, ",", "."),
            'orderDate' => Carbon::parse($order->created_at),
            'expireAt' => !$item->product->service->site->availability_enabled ? Carbon::parse($expireDate)->endOfDay() : null,
            'qrCode' => base64_encode(QrCode::format('png')->margin(0)->size(90)->generate($qrCode)),
            'slotDate' => $item->date_service ? date('d/m/Y', strtotime($item->date_service)) : null,
            'slotHour' => $item->hour_service ? date('H:i', strtotime($item->hour_service)) : null,
            'reduction' => null,
            'validFromUnit' => null,
            'validFromValue' => null,
            'validToDate' => null,
            'notFiscal' => $item->product->service->product_category->slug == 'site-events',

        ];
        $ticketInfo->additional_code = $item->additional_code;

        $ticketInfo->holder = '';

        if ($item->product->is_name) {
            $ticketInfo->holder = isset($item->product_holder) ? $item->product_holder->first_name." ".$item->product_holder->last_name : '';
            $ticketInfo->holder_expired_at = isset($item->product_holder) ? Carbon::parse($item->product_holder->expired_at)->format("d/m/Y H:i") : '';
        }
        return $ticketInfo;
    }

    public static function getValidFileName($string)
    {
        return trim(preg_replace('/[^a-z0-9\-\.~_]+/', '-', strtolower(Str::ascii($string))), ". ");
    }

    public static function collectScanMatrix($orderItem, $qrCode, $virtualStoreMatrixId, $orderType = null, $reduction = null)
    {
        return self::collectScanInfo($orderItem, $qrCode, $virtualStoreMatrixId, null, $orderType, $reduction);
    }

    public static function collectScanInfo($orderItem, $qrCode, $virtualStoreMatrixId = null, $operatorId = null, $orderType = null, $reduction = null)
    {
        $verificationNeeded = 0;
        $now = Carbon::now();
        $expirationDate = self::getTicketExpireDate($now, $orderItem);
        return [
            'siae_order_item_id' => $orderItem->id,
            'operator_id' => $operatorId,
            'virtual_store_matrix_id' => $virtualStoreMatrixId,
            'is_scanned' => 0,
            'verification_needed' => $verificationNeeded,
            'qr_code' => $qrCode,
            'date_scanned' => $now->format("Y-m-d H:i:s"),
            'date_expiration' => $expirationDate->format("Y-m-d H:i:s"),
        ];
    }

    public static function getTicketExpireDate($startingDate, $orderItem = null)
    {
        $expirationDate = ($startingDate instanceof Carbon) ? clone $startingDate : ($startingDate != '' ? Carbon::createFromFormat('Y-m-d H:i:s', $startingDate) : Carbon::now());

        if ($orderItem && !$orderItem->date_service) {
            $validityFromIssueUnit = $orderItem->product->validity_from_issue_unit->value;
            $validityFromIssueValue = $orderItem->product->validity_from_issue_value;
            $expirationDate->add($validityFromIssueValue, $validityFromIssueUnit);
        } else {
            $expirationDate->addMonth(env('TICKET_EXPIRATION_MONTHS'))->endOfDay();
        }

        return $expirationDate;
    }


}
