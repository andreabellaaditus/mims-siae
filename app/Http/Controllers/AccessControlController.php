<?php

namespace App\Http\Controllers;

use App\Models\AccessControlDeviceDebug;
use App\Models\AccessControlChange;
use App\Http\Helpers\Functions;
use App\Http\Helpers\TicketValidator;
use App\Http\Helpers\Zse;
use App\Models\AccessControlDevice;
use App\Models\Site;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use Validator;
use DB;
use Mail;
use PDF;

class AccessControlController extends Controller
{


    const DEBUG = true;

    private $_retXml = '';
    private $_device = null;
    private $_code = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $code = $request->get('code') ? self::StrToHex($request->get('code')) : '3c51e08f6789a431712f0117f1f4508f';
        $device = $request->get('device') ?: '1F0200010002';

        $localDebug = $request->get('localDebug') ?: false;

        if ($request->get('forceXml') == 'setup') {
            $xml = $this->_xmlSampleSetup();
        } elseif ($request->get('forceXml') == 'transit') {
            $code = '313a' . $code;
            $xml = $this->_xmlSampleTransit($device, $code);
        } elseif ($request->get('forceXml') == 'polling') {
            $xml = $this->_xmlSamplePolling(32);
        } elseif ($request->get('forceXml') == 'read') {
            $xml = $this->_xmlSampleRead($device, $code);
        } elseif ($request->get('forceXml') == 'custom') {
            $xml = $request->get('xml');
        } else {
            $xml = file_get_contents("php://input");
        }

        //$this->_log("XML: " . $xml);

        $this->_xmlDebugLogger($xml);

        $r = Zse::getInstance();
        $r->setLocalDebug($localDebug);
        $r->parseXml($xml)->RxAnalize();
        $r->EstimateExecTime();
        if ($request->get('debug') == 1) {
            $r->activeDebugMode();
        }

        $code = trim($r->getCode());
        $this->_code = $code;
        $deviceId = $r->getDeviceId();
        $device = AccessControlDevice::where('code', '=', $deviceId)->first();
        $site = null;
        if ($device) {
            $this->_device = $device;
            $site = $device->site;//$this->_getSiteByDeviceId($deviceId);
        }

        $this->_log("CODE: " . $code);
        $this->_log("DEVICE: " . $deviceId);

        try {

            switch ($r->checkTxStatus()) {

                case Zse::TX_STATUS_READ:
                    $ticketValidator = TicketValidator::getInstance($site, $code);
                    $ticketValidator->setDevice($device);
                    $ticketValidator->checkCode();
                    if ($device->type == 'portello' || $device->burn_before_transit) {
                        $ticketValidator->burnCode();
                        $this->_setTransitResponse($ticketValidator, $r);
                    }
                    $this->_setReaderResponse($ticketValidator, $r);

                    break;

                case Zse::TX_STATUS_TRANSIT:
                    if (strlen($code) > 1 && !$device->burn_before_transit) {

                        list($direction, $code) = explode(':', $code);
                        $this->_log("DIRECTION: " . $code."|".$direction);
                        $ticketValidator = TicketValidator::getInstance($site, $code);
                        $ticketValidator->setDevice($device);
                        $ticketValidator->burnCode($direction);
                        $this->_setTransitResponse($ticketValidator, $r);


                    }
                    break;


                case Zse::TX_STATUS_POLLING:
                    $this->_checkStatus($deviceId, $r->getDeviceStatus());
                    break;
            }
        } catch (\Exception $exception) {
            $message = $r->HeaderMsg('#FFFFFF', '#000000', 0) . $r->StrToHex($exception->getMessage());
            $r->_answErrCode = 1;
            $r->_answMsg = $message;
        }

        $this->_retXml = $r->getXmlResponse();
        $this->_log($this->_retXml);
        if (isset($ticketValidator)) {
            $this->_debugLogger($deviceId, $ticketValidator, $xml, $this->_retXml);
        }

        return response($this->_retXml, 200, [
            'Content-Type' => 'application/xml'
        ]);

    }

    public function validateTicket()
    {
        return response($this->_retXml, 200, [
            'Content-Type' => 'application/xml',
            'X-Accel-Buffering' => 'no',
            'Content-Encoding' => 'none',
            'Cache-Control' => 'no-cache, must-revalidate',
        ]);
    }


    private function _setReaderResponse($ticketValidator, $r)
    {
        $ticketValidatorResponse = $ticketValidator->getResponse();
        $message = $ticketValidatorResponse->message;

        if ($ticketValidatorResponse->status == 'error') {
            $r->setReaderError($message);
            $this->_logLastDeviceMessage($message,'error');
        }
        if ($ticketValidatorResponse->status == 'success') {
            $r->setReaderSuccess($message);
            $this->_logLastDeviceMessage($message,'success');
        }
        if ($ticketValidatorResponse->status == 'warning') {
            $r->setReaderWarning($message);
            $this->_logLastDeviceMessage($message,'warning');
        }
    }

    private function _setTransitResponse($ticketValidator, $r)
    {
        $ticketValidatorResponse = $ticketValidator->getResponse();
        $message = $ticketValidatorResponse->message;

        if ($ticketValidatorResponse->status == 'error') {
            $r->setTransitError($message);
            $this->_logLastDeviceMessage($message,'error');
        }
        if ($ticketValidatorResponse->status == 'success') {
            $r->setTransitSuccess($message);
            $this->_logLastDeviceMessage($message,'success');
        }
        if ($ticketValidatorResponse->status == 'warning') {
            $r->setTransitWarning($message);
            $this->_logLastDeviceMessage($message,'warning');
        }
    }


    private function _checkStatus($deviceId, $newStatus)
    {
        $device = AccessControlDevice::where('code', '=', $deviceId)->first();
        $oldStatus = $device->status;
        if ($oldStatus != $newStatus && $newStatus != null) {
            $device->status = $newStatus;
            $device->save();
            $now = Carbon::now();

            $messageStatus = '';
            switch ($newStatus) {
                case Zse::DEVICE_STATUS_PANIC_MODE:
                    $messageStatus = "Alle ore " . $now->format('H:i') . " del " . $now->format('d/m/Y') . " il tornello <b>" . $device->name . "</b> a <b>" . $device->site->name . "</b> è entrato in modalità emergenza, l'accesso e l'uscita sono libere";
                    break;

                case Zse::DEVICE_STATUS_OPERATIVE:
                    $messageStatus = "Alle ore " . $now->format('H:i') . " del " . $now->format('d/m/Y') . " il tornello <b>" . $device->name . "</b> a <b>" . $device->site->name . "</b> è tornato in modalità operativa, da questo momento il funzionamento normale è stato ripristinato";
                    break;
            }
            $this->_log('POLLING STATUS: ' . $newStatus);
            $this->_InsertLog($device,$messageStatus);

            /*Mail::send('admin.emails.access-control-status', ['messageStatus' => $messageStatus], function ($message) use ($device) {

                $message->from('info@aditusculture.com', 'Aditus Value S.r.l.');
                $message->to(env('TEST_EMAIL_RECIPIENT'));
                $message->subject("Cambio stato per il tornello " . $device->name . " a " . $device->site->name);

            });*/
        }

    }

    private function _log($log)
    {
        if (self::DEBUG) {
            Log::error($log);
        }
    }

    private function _InsertLog($device,$messageStatus)
    {
        AccessControlChange::create([
            'access_control_device_id' => $device->id,
            'message' => $messageStatus
        ]);
    }

    private function _debugLogger($deviceId = null, $ticketValidator = null, $xmlRequest, $xmlResponse)
    {
        $device = AccessControlDevice::where('code', '=', $deviceId)->first();
        if ($device->logging_enabled != 1) {
            return;
        }

        $response = $ticketValidator->getResponse();

        try {
            $log = new AccessControlDeviceDebug();
            $log->status = $response->status;
            $log->access_control_device_id = $device->id;
            $log->message = $response->message;
            $log->qr_code = $ticketValidator->getQrCode();
            $log->qr_code_type = $ticketValidator->getQrCodeType();
            $log->request = $xmlRequest;
            $log->response = $xmlResponse;
            $log->save();
        } catch (\Exception $e) {
            echo $e->getMessage();
            die();
        }

    }

    private function _xmlDebugLogger($xmlRequest)
    {
        try {
            $log = new AccessControlDeviceDebug();
            $log->access_control_device_id = 0;
            $log->request = $xmlRequest;
            $log->save();
        } catch (\Exception $e) {
            Log::error("***AC***" . $e->getMessage());
        }
    }

    private function _getSiteByDeviceId($deviceId)
    {
        $accessControlDevice = AccessControlDevice::where('code', '=', $deviceId)->first();
        return $accessControlDevice instanceof AccessControlDevice ? $accessControlDevice->site : null;

    }

    private function _logLastDeviceMessage($message, $type)
    {

        list($message) = explode('|',$message);
        $code = $this->_code;

        switch ($type) {
            case 'error':
                $color = '#FF0000';
                break;
            case 'warning':
                $color = '#FFCC00';
                break;
            case 'success':
                $color = '#00FF00';
                break;
            default:
                $color = '#FFFFFF';
                break;
        }

        $lastMessage = [
            "message" => $message,
            "type" => $type,
            "color" => $color,
            "code" => $code,
        ];


        $this->_device->last_message = json_encode($lastMessage);
        $this->_device->save();
    }


    private function _xmlSampleSetup()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Terminal>
   <TermInfo>
      <IDM>55</IDM>
      <PIN>1F01000385F5</PIN>
      <IDI>186</IDI>
      <IDR>1</IDR>
      <IDY>ITK121</IDY>
      <IDS>ITK121A0001B204</IDS>
      <MYP>192.168.2.121</MYP>
      <CMD>67</CMD>
      <DAT />
      <FRW>1.3</FRW>
      <HWT>EM2R1</HWT>
      <SET>1</SET>
   </TermInfo>
</Terminal>
XML;
        return $xml;

    }

    private function _xmlSamplePolling($status)
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Terminal>
   <TermInfo>
      <IDM>1</IDM>
      <PIN>1F0200100001</PIN>
      <IDY>XL121</IDY>
      <IDS>XL121A00019904</IDS>
      <MYP>192.168.0.188</MYP>
      <CMD>67</CMD>
      <DAT>$status</DAT>
      <SET>1</SET>
      <FRW>1.5</FRW>
      <HWT>EM2R1</HWT>
   </TermInfo>
</Terminal>
XML;
        return $xml;

    }

    private function _xmlSampleTransit($device, $code)
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Terminal>
   <TermInfo>
      <IDM>89</IDM>
      <PIN>$device</PIN>
      <IDY>XL121</IDY>
      <IDS>XL121A00019904</IDS>
      <MYP>192.168.0.188</MYP>
      <CMD>126</CMD>
      <DAT>$code</DAT>
   </TermInfo>
</Terminal>
XML;
        return $xml;

    }

    private function _xmlSampleRead($device, $code)
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Terminal>
   <TermInfo>
      <IDM>4</IDM>
      <PIN>$device</PIN>
      <IDY>XL121</IDY>
      <IDS>XL121A0001D205</IDS>
      <MYP>192.168.0.126</MYP>
      <CMD>66</CMD>
      <CHL>2</CHL>
      <DAT>$code</DAT>
   </TermInfo>
</Terminal>
XML;
        return $xml;

    }

    static function StrToHex($string)
    {
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0' . $hexCode, -2);
        }
        return strToUpper($hex);
    }

}
