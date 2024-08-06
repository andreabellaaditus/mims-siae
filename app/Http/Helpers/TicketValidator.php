<?php

namespace App\Http\Helpers;

use App\Models\AccessControlPass;
use App\Models\AccessControlQrcodeLog;
use App\Models\CumulativeScan;
use App\Models\SiaeOrderItem;
use App\Models\SiaeOrderItemReduction;
use App\Services\ScanService;
use App\Models\SiaeScan;
use App\Models\Site;
use App\Models\AccessControlDevice;
use App\Models\ProductCumulative;
use App\Models\VirtualStoreMatrix;
use App\Services\ProductService;
use App\Services\SiaeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TicketValidator
{
    const DEBUG = true;

    const RESPONSE_STATUS_ERROR = 'error';
    const RESPONSE_STATUS_SUCCESS = 'success';
    const RESPONSE_STATUS_WARNING = 'warning';
    const RESPONSE_STATUS_INFO = 'info';

    const MESSAGE_CODE_INVALID = 'MESSAGE_CODE_INVALID';
    const MESSAGE_SITE_NOT_SET = 'MESSAGE_SITE_NOT_SET';
    const MESSAGE_CODE_VALID = 'MESSAGE_CODE_VALID';
    const MESSAGE_CODE_USED_MORE_TIME = 'MESSAGE_CODE_USED_MORE_TIME';
    const MESSAGE_CODE_USED_SINGLE_TIME = 'MESSAGE_CODE_USED_SINGLE_TIME';
    const MESSAGE_CODE_SITE_NOT_ENABLE = 'MESSAGE_CODE_SITE_NOT_ENABLE';
    const MESSAGE_CODE_TICKET_REMAINING_QTY = 'MESSAGE_CODE_TICKET_REMAINING_QTY';
    const MESSAGE_CODE_TICKET_CUMULATIVE_EXPIRED = 'MESSAGE_CODE_TICKET_CUMULATIVE_EXPIRED';
    const MESSAGE_CODE_TICKET_EXPIRED = 'MESSAGE_CODE_TICKET_EXPIRED';
    const MESSAGE_CODE_TICKET_FULLY_BURNED = 'MESSAGE_CODE_TICKET_FULLY_BURNED';
    const MESSAGE_CODE_VERIFICATION_NEEDED = 'MESSAGE_CODE_VERIFICATION_NEEDED';
    const MESSAGE_CODE_BURNED = 'MESSAGE_CODE_BURNED';
    const MESSAGE_CODE_EXIT = 'MESSAGE_CODE_EXIT';
    const MESSAGE_CODE_CUMULATIVE = 'MESSAGE_CODE_CUMULATIVE';
    const MESSAGE_CODE_SLOT_INVALID = 'MESSAGE_CODE_SLOT_INVALID';
    const MESSAGE_CODE_DATE_INVALID = 'MESSAGE_CODE_DATE_INVALID';
    const MESSAGE_CODE_ALREADY_OUT = 'MESSAGE_CODE_ALREADY_OUT';
    const MESSAGE_CODE_NOT_ENTERED = 'MESSAGE_CODE_NOT_ENTERED';
    const MESSAGE_GENERIC_ERROR = 'MESSAGE_GENERIC_ERROR';
    const MESSAGE_GENERIC_ERROR_03 = 'MESSAGE_GENERIC_ERROR_03';
    const MESSAGE_GENERIC_ERROR_04 = 'MESSAGE_GENERIC_ERROR_04';
    const MESSAGE_GENERIC_ERROR_05 = 'MESSAGE_GENERIC_ERROR_05';
    const MESSAGE_CODE_GATEWAY_USED_01 = 'MESSAGE_CODE_GATEWAY_USED_01';
    const MESSAGE_CODE_GATEWAY_USED_02 = 'MESSAGE_CODE_GATEWAY_USED_02';

    const QR_CODE_TYPE_PASS = 'pass';
    const QR_CODE_TYPE_EVENT = 'event';
    const QR_CODE_TYPE_ORDER = 'order';
    const QR_CODE_TYPE_ITEM = 'item';
    const QR_CODE_TYPE_SCAN = 'scan';
    const QR_CODE_TYPE_FASTTRACK = 'fastTrack';
    const QR_CODE_TYPE_BUNDLE = 'bundle';

    const MESSAGE_TYPE = 'short';


    const ENTRANCE_TOLLERANCE = 60;

    const FORMAT_DATE = 'd/m/Y';
    const FORMAT_TIME = 'H:i';


    private $_order;
    private $_item;
    private $_scan;
    private $_device;
    private $_site;

    private $_response = null;

    private $_qrCode = null;
    private $_qrCodeType = null;

    private static $instance = null;

    public static function getInstance($site, $code)
    {
        if (self::$instance == null) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        $instance = self::$instance;
        $instance->_site = $site;
        $instance->_qrCode = $code;

        return $instance;
    }


    public function checkCode()
    {

        try {
            $this->_checkSite();
            $this->_setQrCodeType();

            $qrCodeType = $this->_getQrCodeType();

            $this->_log('QRCODE TYPE: ' . $qrCodeType);

            if ($this->isDeviceEntranceEnabled()) {
                $direction = "entrance";
                switch ($qrCodeType) {
                    case self::QR_CODE_TYPE_SCAN:
                        $this->_validateTicketScan();
                        break;

                    case self::QR_CODE_TYPE_PASS:
                        $this->_validatePass();
                        break;
                }
            }

            if ($this->isDeviceExitEnabled()) {
                $direction = "exit";
                $this->_validateOutgoingQrCode();
            }
            $this->trackCode($direction);

        } catch (\Exception $exception) {
            $this->_setError($exception->getMessage());
        }

    }



    public function getInfo()
    {

        try {
            $this->_checkSite();
            $this->_setQrCodeType();

            $qrCodeType = $this->_getQrCodeType();

            $this->_log('QRCODE TYPE: ' . $qrCodeType);
            $this->_getInfoTicketScan();

        } catch (\Exception $exception) {
            $this->_setError($exception->getMessage());
        }

    }


    public function burnCode($direction = null)
    {
        $this->_setQrCodeType();
        try {
            $qrCodeType = $this->_getQrCodeType();
            $this->_log("qrCodeType: " . $qrCodeType);

            if ($this->isDeviceEntranceEnabled()) {
                $typeOfDirection = $direction ?? "entrance";
                switch ($qrCodeType) {

                    case self::QR_CODE_TYPE_SCAN:
                        $this->_burnTicketScan();
                        break;
                }
            }

            if ($this->isDeviceExitEnabled()) {
                $typeOfDirection = $direction ?? "exit";
                $this->_validateOutgoingQrCode();
                switch ($qrCodeType) {

                    case self::QR_CODE_TYPE_SCAN:
                        $this->_burnTicketScan();
                        break;
                }
            }

            $this->trackCode($typeOfDirection);

            $message = $this->_retrieveMessage(self::MESSAGE_CODE_BURNED);
            $this->_setSuccess($message);
        } catch (\Exception $exception) {
            $this->_log("burnCode: " . $exception->getMessage());
            $this->_setError($exception->getMessage());
        }
    }


    public function trackCode($direction=null)
    {
        try {

            $deviceId = $this->getDevice() ? $this->getDevice()->id : null;
            $qrCode = $this->getQrCode();
            $this->_log("trackCode: " . $qrCode."|".$deviceId."|".$direction);
            AccessControlQrcodeLog::create([
                'qr_code' => $qrCode,
                'device_id' => $deviceId,
                'direction' => $direction,
            ]);

        } catch (\Exception $exception) {
            $this->_log("trackCode: " . $exception->getMessage());
            $this->_setError($exception->getMessage());

        }


    }


    /*
     *
     * GETTER
     *
     */


    public function getCode()
    {
        return $this->_qrCode;
    }

    public function getDevice()
    {
        return $this->_device;
    }

    public function getDeviceMaxScans()
    {
        return $this->getSite()->max_scans ?: 1;
    }

    public function getSite()
    {
        return $this->_device->site;
    }

    public function getScan()
    {
        return $this->_scan;
    }

    public function getOrder()
    {
        return $this->_order;
    }

    public function getItem()
    {
        return $this->_item;
    }

    public function isDeviceEntranceEnabled()
    {
        return $this->getDevice() instanceof AccessControlDevice ?
            (
            $this->getDevice()->entrance_enabled ? true : false
            )
            : false;
    }

    public function isDeviceExitEnabled()
    {
        return $this->getDevice() instanceof AccessControlDevice ?
            (
            $this->getDevice()->exit_enabled ? true : false
            )
            : false;
    }

    /*
     *
     * SETTER
     *
     */

    public function setDevice($device)
    {
        return $this->_device = $device;
    }

    private function _checkSite()
    {
        if (!$this->_site instanceof Site) {
            $message = $this->_retrieveMessage(self::MESSAGE_SITE_NOT_SET);
            throw new \Exception($message);
        }
    }


    private function _setQrCodeType()
    {
        if ($this->_scanPass = AccessControlPass::where('qr_code', '=', $this->_qrCode)->first()) {
            $this->_qrCodeType = self::QR_CODE_TYPE_PASS;
        } elseif ($this->_scan = SiaeScan::where('qr_code', $this->_qrCode)->first()) {
            $this->_qrCodeType = self::QR_CODE_TYPE_SCAN;
            $this->_item = $this->_scan->order_item;
        } else {
            $message = $this->_retrieveMessage(self::MESSAGE_CODE_INVALID);
            throw new \Exception($message);
        }
    }

    private function _getQrCodeType()
    {
        return $this->_qrCodeType;
    }

    public function getQrCodeType()
    {
        return $this->_qrCodeType;
    }

    public function getQrCode()
    {
        return $this->_qrCode;
    }

    private function _isPassScan()
    {
        return $this->_scanPass instanceof AccessControlPass ? true : false;
    }

    private function _validatePass()
    {
        $now = Carbon::now();

        try {

            $pass = $this->_scanPass;
            $scanQrCode = $pass->qr_code;

            try {

                if (!$this->_isPassScan()) {
                    $message = $this->_retrieveMessage(self::MESSAGE_CODE_INVALID);
                    throw new \Exception($message);
                }

                $expireDate = $pass->expireDate;
                $enabledSitesIds = $pass->enabledSitesIds;

                if (!in_array($this->_getSourceSiteId(), $enabledSitesIds)) {
                    $message = $this->_retrieveMessage(self::MESSAGE_CODE_SITE_NOT_ENABLE);
                    throw new \Exception($message);
                } elseif (!$now->lessThanOrEqualTo($expireDate)) {
                    $message = $this->_retrieveMessage(self::MESSAGE_CODE_TICKET_EXPIRED);
                    throw new \Exception($message);
                }

                $message = $this->_retrieveMessage(self::MESSAGE_CODE_VALID);
                $this->_setSuccess($message);

                $deviceId = $this->getDevice() ? $this->getDevice()->id : null;
                $qrCode = $this->getQrCode();

                AccessControlQrcodeLog::create([
                    'qr_code' => $qrCode,
                    'device_id' => $deviceId
                ]);


            } catch (\Exception $e) {
                $this->_setError($e->getMessage());
            }

        } catch (\Exception $e) {
            $this->_setError($e->getMessage());
        }
    }


    private function _validateTicketScan($scan = null)
    {
        $now = Carbon::now()->format('Y-m-d h:i:s');

        $scan = $scan ?: $this->_scan;
        $scanQrCode = $scan->qr_code;

        // Aggiunta verifica se biglietto già usato in quest'area
        $deviceId = $this->getDevice() ? $this->getDevice()->id : null ;
        $device = AccessControlDevice::where('id', $deviceId)->first();
        $deviceArea = $device->area;
        $scanArea = (array) json_decode($scan->scan_area);
        $deviceAreas[] = $deviceArea;
        $product = $scan->order_item->product;
        $currScan = $scan->is_scanned;

        if(!$product->is_cumulative){
            if ($device->site_id != $product->service->site_id) {
                $message = $this->_retrieveMessage(self::MESSAGE_CODE_SITE_NOT_ENABLE);
                throw new \Exception($message);
            }
        }else{
            $check_sites = ProductCumulative::where(['product_id' => $product->id, 'site_id' => $device->site_id])->count();
            if(!$check_sites){
                $message = $this->_retrieveMessage(self::MESSAGE_CODE_SITE_NOT_ENABLE);
                throw new \Exception($message);
            }
        }
        if ($currScan >= $product->max_scans) {
            $message = $this->_retrieveMessage(self::MESSAGE_CODE_TICKET_FULLY_BURNED);
            throw new \Exception(sprintf($message));
        }

        if ($deviceArea && is_array($scanArea) && in_array($deviceArea, $scanArea)) {
            $message = $this->_retrieveMessage(self::MESSAGE_CODE_GATEWAY_USED_01);
            throw new \Exception(sprintf($message));
        }


        if($product->service->product_category->slug == 'site-events'){
            $siaeService = new SiaeService();
            $checkIngresso = $siaeService->verificaPerIngressoTornello($product->code, $scan->qr_code);
            if(!$checkIngresso->esito){
                $message = $this->_retrieveMessage($checkIngresso->messaggio);
                throw new \Exception(sprintf($message));
            }
        }



        try {
            if (!$this->_isScan()) {
                $message = $this->_retrieveMessage(self::MESSAGE_CODE_INVALID);
                throw new \Exception($message);
            }
            $product = $this->_scan->order_item->product->related_product ? $this->_scan->order_item->product->related_product : $this->_scan->order_item->product;

            $maxScans = $this->_getMaxScansByProduct($product);
            $scanSiteId = $product->service->site_id;

            if($product->is_cumulative){
                $check_sites = ProductCumulative::where(['product_id' => $product->id, 'site_id' => $device->site_id])->count();
                if(!$check_sites){
                    $message = $this->_retrieveMessage(self::MESSAGE_CODE_SITE_NOT_ENABLE);
                    throw new \Exception($message);
                }
            }elseif ($this->_getSourceSiteId() != $scanSiteId) {
                $message = $this->_retrieveMessage(self::MESSAGE_CODE_SITE_NOT_ENABLE);
                throw new \Exception($message);
            } elseif ($this->_scan->date_expiration && $now > $this->_scan->date_expiration) {
                $message = $this->_retrieveMessage(self::MESSAGE_CODE_TICKET_EXPIRED,
                    ['giorno', $this->_scan->created_at]);
                throw new \Exception($message);
            }

            if (!self::_isValidSlot()) {
                $message = $this->_retrieveMessage(self::MESSAGE_CODE_SLOT_INVALID);
                throw new \Exception($message);
            }

            if ($product->is_cumulative) {
                $cumulativeScans = CumulativeScan::where('qr_code', '=', $scanQrCode)->orderBy('created_at',
                    'asc')->count();

                if ($cumulativeScans) {
                    $this->_checkValidityDate($scan);
                    $this->_checkValidityEntrance($scan, $this->_getSourceSiteId());
                }

                $message = $this->_retrieveMessage(self::MESSAGE_CODE_VALID);
                $this->_setSuccess($message);
            } else {

                $scans = $this->_scan->is_scanned;
                if ($scans >= $maxScans) {
                    $message = $this->_retrieveMessage(self::MESSAGE_CODE_USED_MORE_TIME, [$scans]);
                    throw new \Exception(sprintf($message));
                }
                elseif (!$scans) {
                    if ($this->_scan->verification_needed == 1) {
                        $message = $this->_retrieveMessage(self::MESSAGE_CODE_VERIFICATION_NEEDED);
                        $this->_setWarning($message);
                    } else {
                        $message = $this->_retrieveMessage(self::MESSAGE_CODE_VALID);
                        $this->_setSuccess($message);
                    }
                } else {
                    $message = $this->_retrieveMessage(self::MESSAGE_CODE_VALID);
                    $this->_setSuccess($message);
                }
            }
        } catch (\Exception $e) {
            $this->_setError($e->getMessage());
        }

    }


    private function _validateOutgoingQrCode()
    {
        $code = $this->getQrCode();
        $accessControlQrcodeLogIn = $this->_getTransitCounter($code, 'entrance');
        $accessControlQrcodeLogOut = $this->_getTransitCounter($code, 'exit');

        if ($accessControlQrcodeLogIn == 0) {
            $message = $this->_retrieveMessage(self::MESSAGE_CODE_NOT_ENTERED);
            throw new \Exception($message);
        } elseif ($accessControlQrcodeLogOut >= $accessControlQrcodeLogIn) {
            $message = $this->_retrieveMessage(self::MESSAGE_CODE_ALREADY_OUT);
            throw new \Exception($message);
        }

        $message = $this->_retrieveMessage(self::MESSAGE_CODE_EXIT);
        $this->_setSuccess($message);
    }

    private function _getTransitCounter($code, $type)
    {
        $now = \ITHolidays\Carbon::now();
        $dateStart = clone $now;
        $dateStart->startOfDay();
        $dateEnd = clone $now;
        $dateEnd->endOfDay();

        switch ($type) {

            case 'entrance':
                $typeFieldEnabled = 'entrance_enabled';
                break;
            case 'exit':
                $typeFieldEnabled = 'exit_enabled';
                break;
            default:
                $typeFieldEnabled = null;

        }

        $counter = AccessControlQrcodeLog::leftJoin('access_control_devices', 'access_control_qrcode_logs.device_id',
            '=', 'access_control_devices.id')
            ->where('access_control_qrcode_logs.qr_code', '=', $code)
            ->where('access_control_qrcode_logs.created_at', '>=', $dateStart->format('Y-m-d H:i:s'))
            ->where('access_control_qrcode_logs.created_at', '<=', $dateEnd->format('Y-m-d H:i:s'))
            ->where('access_control_devices.' . $typeFieldEnabled, '=', 1);

        return $counter->count();

    }

    private function _getInfoTicketScan($scan = null)
    {
        $scan = $scan ?: $this->_scan;

        try {

            if (!$this->_isScan()) {
                $message = $this->_retrieveMessage(self::MESSAGE_CODE_INVALID);
                throw new \Exception($message);
            }

            $product = $scan->order_item->product->related_product ? $scan->order_item->product->related_product : $scan->order_item->product;
            $expirationDate = $scan->order_item->date_service && $scan->order_item->hour_service ? null : Carbon::parse($scan->date_expiration);

            $this->_setInfo('', $product->name, '', $this->_site->name, $product->check_document, 1, $scan->is_scanned,
                $scan->verification_needed, $scan->order_item->date_service, $scan->order_item->hour_service,
                $scan->order_item_reduction, $expirationDate);

        } catch (\Exception $e) {
            $this->_setError($e->getMessage());
        }

    }

    private function _getSourceSiteId()
    {
        return $this->_site instanceof Site ? $this->_site->id : null;
    }

    public function getSourceSiteName()
    {
        return $this->_site instanceof Site ? $this->_site->name : null;
    }

    private function _isScan()
    {
        return $this->_scan instanceof SiaeScan ? true : false;
    }

    private function _getNow()
    {
        return Carbon::now('Europe/Rome');
    }

    private function _setError(
        $message,
        $product = '',
        $site = '',
        $checkDocument = 0,
        $pax = 0,
        $scans = 0
    )
    {
        $status = self::RESPONSE_STATUS_ERROR;
        $this->_setResponseData($status, $message, $product, $site, $checkDocument, $pax, $scans);
    }

    private function _setWarning(
        $message,
        $product = '',
        $site = '',
        $checkDocument = 0,
        $pax = 0,
        $scans = 0
    )
    {
        $status = self::RESPONSE_STATUS_WARNING;
        $this->_setResponseData($status, $message, $product, $site, $checkDocument, $pax, $scans);
    }

    private function _setSuccess(
        $message,
        $product = '',
        $site = '',
        $checkDocument = 0,
        $pax = 0,
        $scans = 0
    )
    {
        $status = self::RESPONSE_STATUS_SUCCESS;
        $this->_setResponseData($status, $message, $product, $site, $checkDocument, $pax, $scans);
    }

    private function _setInfo(
        $message,
        $product = '',
        $site = '',
        $checkDocument = 0,
        $pax = 0,
        $scans = 0,
        $verificationNeeded = false,
        $dateService = null,
        $hourService = null,
        $reduction = null,
        $expirationDate = null
    )
    {
        $status = self::RESPONSE_STATUS_INFO;
        $this->_setResponseData($status, $message, $product, $site, $checkDocument, $pax, $scans, $verificationNeeded,
            $dateService, $hourService, $reduction, $expirationDate);
    }


    private function _setResponseData(
        $status,
        $message,
        $product = '',
        $site = '',
        $checkDocument = 0,
        $pax = 0,
        $scans = 0,
        $verificationNeeded = false,
        $dateService = null,
        $hourService = null,
        $reduction = null,
        $expirationDate = null
    )
    {
        $date = null;
        if ($dateService) {
            $date = Carbon::parse($dateService);
        }

        if ($hourService && $dateService) {
            $date->setTimeFromTimeString($hourService);
        }

        $response = new \StdClass;
        $response->status = $status;
        $response->message = $message;
        $response->product = $product;
        $response->site = $site;
        $response->pax = $pax;
        $response->scans = $scans;
        $response->check_document = $checkDocument;
        $response->verification_needed = $verificationNeeded;
        $response->expiration_date = $expirationDate;
        $response->date_service = $date instanceof Carbon ? $date->format(self::FORMAT_DATE) : null;
        $response->hour_service = $date instanceof Carbon ? $date->format(self::FORMAT_TIME) : null;


        if ($reduction instanceof SiaeOrderItemReduction) {
            $response->reduction['reduction_info'] = true;
            $response->reduction['reduction_type'] = $reduction->reduction->short_reduction;
            $response->reduction['reduction_first_name'] = $reduction->first_name;
            $response->reduction['reduction_last_name'] = $reduction->last_name;
            $response->reduction['reduction_document_type'] = $reduction->document_type->label;
            $response->reduction['reduction_document_id'] = $reduction->document_id;
            $response->reduction['reduction_document_expire_at'] = $reduction->document_expire_at;
        }

        $this->_response = $response;


    }

    private function _checkValidityDate($scan)
    {
        $now = $this->_getNow();

        if ($scan instanceof SiaeScan) {
            $qrCode = $scan->qr_code;
            $productService = new ProductService($scan->virtual_store_matrix->product);
            $product = $scan->virtual_store_matrix->product;
        } elseif ($scan instanceof SiaeOrderItem) {
            $qrCode = $scan->printable_qr_code;
            $scanProduct = $scan->product->related_product ?: $scan->product;
            $productService = new ProductService($scanProduct);
            $product = $scanProduct;
        } else {
            $message = $this->_retrieveMessage(self::MESSAGE_GENERIC_ERROR_04);
            throw new \Exception($message);
        }

        $firstScan = CumulativeScan::where('qr_code', '=', $qrCode)
            ->whereRaw('DATE(created_at) <= ?',
                $now->subDays($productService->getValidityDays())->format('Y-m-d H:i:s'))
            ->orderBy('created_at', 'asc')
            ->first();

        if ($firstScan) {
            $message = $this->_retrieveMessage(self::MESSAGE_CODE_TICKET_CUMULATIVE_EXPIRED,
                [$product->validity_from_burn_value, $product->validity_from_burn_unit->value, $firstScan->created_at, $firstScan->site->name]);
            throw new \Exception(sprintf($message));
        }

    }

    private function _checkValidityEntrance($scan, $sourceSiteId)
    {

        if ($scan instanceof SiaeScan) {
            $qrCode = $scan->qr_code;
        } elseif ($scan instanceof SiaeOrderItem) {
            $qrCode = $scan->printable_qr_code;
        } else {
            $message = $this->_retrieveMessage(self::MESSAGE_GENERIC_ERROR_05);
            throw new \Exception($message);
        }

        $burnedSites = [];
        $cumulativeScans = CumulativeScan::where('qr_code', '=', $qrCode)->orderBy('created_at', 'asc')->get();
        $cumulativeScan = CumulativeScan::where('site_id', '=', $sourceSiteId)
            ->where('qr_code', '=', $qrCode)
            ->first();

        foreach ($scan->order_item->product->sites as $site) {
            $enabledSites[] = $site->id;
        }

        foreach ($cumulativeScans as $scan) {
            $cumulativeSite = ProductCumulative::where(['site_id' => $sourceSiteId, 'product_id' => $scan->product_id ])->first();

            if ($cumulativeScan &&
                $scan->site_id == $sourceSiteId &&
                $cumulativeScan->scans < $cumulativeSite->max_scans) {

            } else {
                $burnedSites[$scan->site_id] = $scan->site->name . " (" . $scan->created_at . ")";
                if (in_array($scan->site_id, $enabledSites)) {
                    if (($key = array_search($scan->site_id, $enabledSites)) !== false) {
                        unset($enabledSites[$key]);
                    }
                }
            }
        }

        if (!in_array($sourceSiteId, $enabledSites)) {
            $burnedSitesList = implode(', ', $burnedSites);

            $message = $this->_retrieveMessage(self::MESSAGE_CODE_TICKET_FULLY_BURNED, [$burnedSitesList]);
            throw new \Exception($message);
        }

    }

    private function _isValidSlot()
    {
        $scanService = new ScanService();
        if($this->_item->date_service != null){
            if($this->_item->date_service == date('Y-m-d')){
                if($this->_item->hour_service != null){

                    $weekday_order = strtolower(date('D', strtotime($this->_item->date_service)));

                    $slot = $scanService->getHour($weekday_order, 'product_id', $this->_item->product_id);
                    if(!$slot){
                        $slot = $scanService->getHour($weekday_order, 'service_id', $this->_item->product->service_id);
                    }

                    $this->_item->hour_service_min = Carbon::parse($this->_item->hour_service)->subMinutes($slot->advance_tolerance)->format("H:i:s");
                    $this->_item->hour_service_max = Carbon::parse($this->_item->hour_service)->addMinutes($slot->delay_tolerance)->format("H:i:s");

                    if($this->_item->hour_service_min > date('H:i:s') || $this->_item->hour_service_max < date('H:i:s')){
                        return false;
                    }
                }
            }else{
                return false;
            }
        }

        return true;
    }

    private function _burnTicketScan()
    {
        $product = $this->_item->product->related_product ? $this->_item->product->related_product : $this->_item->product;

        if ($product->is_cumulative) {
            $this->_writeCumulativeScan($this->_getSourceSiteId());
        }

        $this->_burnScan($this->_scan);
    }

    public function getResponse()
    {
        return $this->_response;
    }


    private function _burnScan($scan)
    {
        $now = $this->_getNow();
        $deviceId = $this->getDevice() ? $this->getDevice()->id : null ;
        $device = AccessControlDevice::where('id', $deviceId)->first();
        $deviceArea = $device->area;
        $scanArea = (array) json_decode($scan->scan_area);
        $deviceAreas[] = $deviceArea;

        $product = $scan->order_item->product;
        $validityFromBurnUnit = $product->validity_from_burn_unit->value;
        $validityFromBurnValue = $product->validity_from_burn_value;
        $currScan = $scan->is_scanned;

        if ($currScan >= $product->max_scans) {
            $message = $this->_retrieveMessage(self::MESSAGE_CODE_TICKET_FULLY_BURNED);
            throw new \Exception(sprintf($message));
        }

        if ($deviceArea && is_array($scanArea) && in_array($deviceArea, $scanArea)) {

            $message = $this->_retrieveMessage(self::MESSAGE_CODE_GATEWAY_USED_02);
            throw new \Exception(sprintf($message));
        }

        $scan->is_scanned = $currScan + 1;
        if ($deviceArea){
            $areasMerge = is_array($scanArea) ? json_encode(array_merge($scanArea, $deviceAreas)) : json_encode($deviceAreas);
            $scan->scan_area = $areasMerge;
        }

        $scan->date_scanned = $now->format('Y-m-d H:i:s');
        if (isset($validityFromBurnUnit) && isset($validityFromBurnValue)) {
            if (!$currScan) {
                $dateExpiration = $now;
                switch ($validityFromBurnUnit) {
                    case "days":
                        $dateExpiration = $now->addDays($validityFromBurnValue)->subDay(1);
                        break;
                    case "weeks":
                        $dateExpiration = $now->addWeeks($validityFromBurnValue);
                        break;
                    case "months":
                        $dateExpiration = $now->addMonths($validityFromBurnValue);
                        break;
                    case "years":
                        $dateExpiration = $now->addYears($validityFromBurnValue);
                        break;
                }
                $scan->date_expiration = $dateExpiration->endOfDay()->format('Y-m-d H:i:s');

            }
        } else {
            $scan->date_expiration = $now->endOfDay()->format('Y-m-d H:i:s');
        }

        if($scan->order_item->product->service->product_category->slug == 'site-events'){
            $siaeService = new SiaeService();
            $checkIngresso = $siaeService->ingressoEffettuatoTornelli($scan->order_item->product->code, $scan->qr_code);
            if($checkIngresso !== true){
                $message = $this->_retrieveMessage($checkIngresso);
                throw new \Exception(sprintf($message));
            }
        }

        $scan->save();
        VirtualStoreMatrix::find($scan->virtual_store_matrix_id)->update([
            'status' => 'Matrice Utilizzata'
        ]);
    }

    private function _writeCumulativeScan($sourceSiteId)
    {
        $scan = $this->_scan;
        $deviceId = $this->getDevice() ? $this->getDevice()->id : null ;
        $device = AccessControlDevice::where('id', $deviceId)->first();
        $deviceArea = $device->area;
        $scanArea = (array) json_decode($scan->scan_area);
        $deviceAreas[] = $deviceArea;

        $product = $scan->order_item->product;
        $currScan = $scan->is_scanned;

        if ($currScan >= $product->max_scans) {
            $message = $this->_retrieveMessage(self::MESSAGE_CODE_TICKET_FULLY_BURNED);
            throw new \Exception(sprintf($message));
        }

        if ($deviceArea && is_array($scanArea) && in_array($deviceArea, $scanArea)) {
            $message = $this->_retrieveMessage(self::MESSAGE_CODE_GATEWAY_USED_02);
            throw new \Exception(sprintf($message));
        }

        $cumulativeScan = CumulativeScan::where('site_id', '=', $sourceSiteId)
            ->where('qr_code', '=', $this->_qrCode)
            ->first();
        if (!$cumulativeScan) {
            $cumulativeScan = new CumulativeScan();
            $cumulativeScan->qr_code = $this->_qrCode;
            $cumulativeScan->product_id = $this->_item->product_id;
            $cumulativeScan->site_id = $sourceSiteId;
            $cumulativeScan->scans = 1;
            $cumulativeScan->save();
        } else {
            $cumulativeScan->increment('scans');
            $cumulativeScan->save();
        }

    }

    private function _retrieveMessage($code, $params = [])
    {
        $_params = [];
        foreach ($params as $index => $param) {
            $_params['p' . $index] = $param;
        }
        $firstRow = trans('access_control.' . self::MESSAGE_TYPE . '.' . $code, $_params, 'it');
        $secondRow = trans('access_control.' . self::MESSAGE_TYPE . '.' . $code, $_params, 'en');

        return $firstRow . "|" . $secondRow;
    }

    private function _log($log)
    {
        if (self::DEBUG) {
            Log::error($log);
        }
    }

    private function _getMaxScansByProduct($product)
    {
        $maxScans = $product->max_scans ? : 1;
        return $maxScans;
    }

}
