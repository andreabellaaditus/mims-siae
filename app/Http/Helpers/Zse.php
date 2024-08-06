<?php

namespace App\Http\Helpers;


use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use SebastianBergmann\Environment\Console;
use Spatie\ArrayToXml\ArrayToXml;

class Zse
{

    const DEBUG = true;

    const DAT_PLL_OPR = 31;
    const DAT_PLL_APM = 32;

    const CMD_A = 65;
    const CMD_RDR_B = 66;
    const CMD_PLL_CHK = 67;           // CHECK
    const CMD_D = 68;
    const CMD_E = 69;
    const CMD_K = 75;
    const CMD_M = 77;
    const CMD_N = 78;
    const CMD_P = 80;
    const CMD_R = 82;
    const CMD_RDR_S = 83;
    const CMD_RDR_T = 84;
    const CMD_RDR_U = 85;

    const CMD_V = 86;           // EXECUTE ACCESS
    const CMD_W = 87;
    const CMD_Y = 89;
    const CMD_H = 72;
    const CMD_J = 74;
    const CMD_Q = 81;
    const CMD_L = 76;           // LOG EVENT

    const CMD_ACT_TRN = 126;           // TRANSIT OCCURRED

    const AWC_PLL_CHK = 67;           //
    const AWC_PLL_ACK = 75;           //
    const AWC_ACT_TRN = 76;           //
    const AWC_RDR_TRN = 86;           //


    const TX_STATUS_CHECK = 'check';
    const TX_STATUS_READ = 'read';
    const TX_STATUS_TRANSIT = 'transit';
    const TX_STATUS_POLLING = 'polling';
    const TX_STATUS_INVALID = 'invalid';

    const DEVICE_STATUS_OPERATIVE = 'operative';
    const DEVICE_STATUS_PANIC_MODE = 'panic-mode';

    const GENERICEXEPT = 1;
    const DEVPINCODE = 2;
    const DEVNOTREGISTERED = 3;
    const DEVTYPEUNKNOWN = 4;
    const CMDERROR = 5;


    //STATUS
    private $_deviceStatus = null;

    // INPUT
    private $_xmlstr = '';       // Input String (Must be XML format)

    // RETURN
    public $_xmlAnswer = '';       // Output String Answer XML

    // LOCAL VARS
    private $_xml = null;     // XML Type
    private $_idPlant = 0;
    private $_idReader = 0;


    // READER VARS
    private $_displayPresent = true;     // Display presence
    private $_idRtxMsg = 0;        // Id Message
    private $_devicePin = '';       // Device Pin Code
    private $_remoteIp = '';       // IP remoto di Richiesta
    private $_termIp = '';       // IP del Terminale
    private $_termSerial = '';       // Terminal Serial Number
    private $_typeModel = '';       // Modello di Device
    private $_readerCmd = '';       // Command
    private $_readerData = '';       // Data

    // ANSWER PARAMETER
    public $_answErrCode = 0;       // ANSWER ERROR CODE
    public $_answCmd = 0;           // ANSWER COMMAND
    public $_answData = '';         // ANSWER DATA
    public $_answMsg = '';          // MESSAGE TO DISPLAY
    public $_answLed = '';          // LED DISPLAY
    //
    // ANSWER SETUP INFO
    public $_answSetup = '';        // PARAM CONFIG READER
    public $_answMifare = '';       // PARAM CONFIG MIFARE
    public $_answBarcode = '';      // PARAM CONFIG BARCODE
    public $_answNewFrw = '';       // NUOVO FIRMWARE INFO


    public $_serverTimeStart = 0;       // NUOVO FIRMWARE INFO


    private $_xmlParsed;
    private $_xmlStr;
    private $_debug = false;
    private $_localDebug = false;

    private static $instance = null;

    private function __construct()
    {
        $this->_serverTimeStart = microtime(true);
    }


    public static function getInstance()
    {
        if (self::$instance == null) {
            $c = __CLASS__;
            self::$instance = new $c;
        }

        $instance = self::$instance;
        return $instance;
    }

    public function activeDebugMode()
    {
        $this->_debug = true;
    }

    public function parseXml($xmlToParse)
    {
        $this->_xmlStr = $xmlToParse;
        $this->_xmlParsed = simplexml_load_string($xmlToParse);
        $this->_log($xmlToParse);
        return $this;
    }


    public function RxAnalize()
    {

        try {

            //
            $this->_idRtxMsg = intval($this->_xmlParsed->TermInfo->IDM);     // Id Message
            $this->_devicePin = $this->_xmlParsed->TermInfo->PIN;             // Device Pin Code
            $this->_remoteIp = $this->getClientIP();                  // IP remoto di Richiesta
            $this->_termIp = $this->_xmlParsed->TermInfo->MYP;             // IP del Terminale
            $this->_termSerial = $this->_xmlParsed->TermInfo->IDS;             // Terminal Serial Number
            $this->_typeModel = $this->_xmlParsed->TermInfo->IDY;             // Modello di Device
            $this->_readerCmd = intval($this->_xmlParsed->TermInfo->CMD);     // Command
            $this->_readerData = $this->HexToStr($this->_xmlParsed->TermInfo->DAT);   // Data


            // CHECK IF THE DEVICE PINCODE IS SET
            if (strlen($this->_devicePin) == 0) {
                $this->_setPinAndMsg($this->_devicePin, $this->_idRtxMsg);
                $this->_answErrCode = self::DEVPINCODE;
                $this->_xmlMsg = $this->HeaderMsg('#FFFFFF', '#FF0000',
                        0).$this->StrToHex("^DEVICE PIN CODE|NOT CONFIGURED");
                if (self::DEBUG) {
                    Log::debug("\nPINCODE IS NULL");
                }
                return;
            }
            if (self::DEBUG) {
                Log::debug("\nPINCODE IS NOT NULL");
            }


            // CHECK IF THE DEVICE PINCODE IS REGISTERED INSIDE THE DATABASE
            if ($this->_identifyIdDevice($this->_devicePin) == false) {
                $this->_setPinAndMsg($this->_devicePin, $this->_idRtxMsg);
                $this->_answErrCode = self::DEVNOTREGISTERED;
                $this->_xmlMsg = $this->HeaderMsg('#FFFFFF', '#FF0000', 0).$this->StrToHex("^DEVICE NOT REGISTER");
                if (self::DEBUG) {
                    Log::debug("\nPINCODE IS NOT ASSIGNED TO A DEVICE.");
                }
                return;
            }
            if (self::DEBUG) {
                Log::debug("\nPINCODE IS ASSIGNED TO : PLANT ($this->_idPlant) AND DEVICE ($this->_idReader)");
            }

            // SWITCH FOR Reader Model Type
            switch ($this->_typeModel) {

                case 'ITK007': // DESK READER
                case 'XL007' :
                    // ...
                    break;

                case 'ITK104':  // BARCODE READER
                case 'XL104':
                    // ...
                    break;

                case 'ITK121':  // TERMINAL READER WITH DISPLAY
                case 'XL121':
                    $this->_displayPresent = true;
                    $this->_analizeCommand();
                    break;

                case 'ITK122':  // TERMINAL READER - WEIGAND NO DISPLAY
                case 'XL122':
                    // ...
                    break;

                default :
                {
                    $this->_setPinAndMsg($this->_devicePin, $this->_idRtxMsg);
                    $this->_answErrCode = self::DEVTYPEUNKNOWN;
                    $this->_answMsg = $this->HeaderMsg('#FFFFFF', '#000000', 0).$this->StrToHex("^DEV.TYPE UNKNOWN");
                    if (self::DEBUG) {
                        Log::debug("\nDEVICE MODEL UNKNOWN");
                    }
                }
            }

        } catch (\Exception $e) {
            //ToLogError($e, $this->xmlstr);
            $this->_setPinAndMsg($this->_devicePin, $this->_idRtxMsg);
            $this->_answErrCode = self::GENERICEXEPT;
            $this->_answMsg = $this->HeaderMsg('#FFFFFF', '#000000', 0).$this->StrToHex("^GENERIC ERROR");
            if (self::DEBUG) {
                Log::debug("\nERROR XML DECODING \n".$e->getMessage());
            }
        }

        return;

    }

    /*
     * CALCULATE THE EXECUTION TIME
     */
    public function EstimateExecTime()
    {
        $ServerWorkTime = (1000 * (microtime(true) - $this->_serverTimeStart));
        $this->_xmlAnswer = str_replace('{RTX}', sprintf('%04d', $ServerWorkTime), $this->_xmlAnswer);
        if (self::DEBUG) {
            Log::debug("\nEXECUTION TIME : $ServerWorkTime mSec.");
        }
    }


    public function getCode()
    {
        return $this->_readerData;
    }

    public function getDeviceId()
    {
        return $this->_devicePin;
    }


    /*
    ** DEVICE TYPE MODEL XL121\ITK121 E XL122\ITK122
    */
    private function _analizeCommand()
    {
        /*
        ** Analize Reader Command
        */
        if (self::DEBUG) {
            Log::debug("\nDEVICE RX COMMAND : $this->_readerCmd");
        }

        $txStatus = $this->checkTxStatus();

        $this->_log("TX-STATUS:".$txStatus);

        switch ($txStatus) {

            case self::TX_STATUS_CHECK:  // Check
            case self::TX_STATUS_POLLING:  // Check
                $this->_CMD_C_Received();
                break;
            case self::TX_STATUS_READ:  // Check
            case self::TX_STATUS_TRANSIT:  // Check
                break;
            default :
            {
                $this->_setPinAndMsg($this->_devicePin, $this->_idRtxMsg);
                $this->_answErrCode = self::CMDERROR;
                $this->_answMsg = $this->HeaderMsg('#FFFFFF', '#000000', 0).$this->StrToHex("^CMD ERROR");
            }

        } // SWITCH

    }

    public function checkTxStatus()
    {
        switch ($this->_readerCmd) {

            case self::CMD_PLL_CHK:  // Check

                if (isset($this->_xmlParsed->TermInfo->DAT) &&
                    in_array($this->_xmlParsed->TermInfo->DAT, [
                        self::DAT_PLL_APM,
                        self::DAT_PLL_OPR
                    ])) {
                    $status = self::TX_STATUS_POLLING;
                } else {
                    $status = self::TX_STATUS_CHECK;
                }

                break;

            case self::CMD_ACT_TRN:  // AVVENUTO TRANSITO
                $status = self::TX_STATUS_TRANSIT;
                break;

            case self::CMD_RDR_S:  // Card Read
            case self::CMD_RDR_T:
            case self::CMD_RDR_U:
            case self::CMD_RDR_B:  // Barcode Read
                $status = self::TX_STATUS_READ;
                break;

            default :
            {
                $status = self::TX_STATUS_INVALID;
            }

        }

        return $status;
    }


    /*
    **  CHECK POLLING FROM TERMINAL
    */
    private function _CMD_C_Received()
    {

        // FIRST CHECK WITH SETUP REQUEST ?
        $SetupRequest = 0;
        if (isset($this->_xmlParsed->TermInfo->SET)) {
            $SetupRequest = intval($this->_xmlParsed->TermInfo->SET);               // CHECK WITH SETUP REQUEST ?
        }

        if (isset($this->_xmlParsed->TermInfo->DAT) &&
            in_array($this->_xmlParsed->TermInfo->DAT, [
                self::DAT_PLL_APM,
                self::DAT_PLL_OPR
            ])) {
            $pollingData = intval($this->_xmlParsed->TermInfo->DAT);               // POLLING DATA
        }

        // ANSWER
        $this->_setPinAndMsg($this->_devicePin, $this->_idRtxMsg);

        // FIRST CHECK WITH SETUP REQUEST ?
        if ($SetupRequest > 0) {
            // SETUP YES => SEND READER SETUP INFO
            //
            // SAVE TO DB READER INFO : FIRMWARE VERSION, DEVICE SERIAL NUMBER, DEVICE MODEL
            // TerminalInfoSave($this->xml->TermInfo->FRW, $this->TermSerial, $this->TypeModel);
            //
            // READ DEVICE CONFIGURATION FROM DB
            $this->_answSetup = $this->_deviceConfig();            // PARAM CONFIG READER
            $this->_answMifare = '000000000000000000000000';      // PARAM CONFIG MIFARE
            $this->_answBarcode = '0000000000';                   // PARAM CONFIG BARCODE
            $this->_answNewFrw = '';                              // NEW FIRMWARE INFO
            $this->_answCmd = self::AWC_PLL_CHK;         // Answer CMD : CHECK
        } else {
            // SETUP NO => NO

            if (isset($pollingData)) {
                $this->_setDeviceStatus($pollingData);
            }
            $this->_answCmd = self::AWC_PLL_ACK;         // Answer CMD : ACK
        }


    } // CMD_C_Received


    private function _deviceConfig()
    {
        $c = '1';       // ENABLE DEVICE 0=DISABLED  1=ENABLED
        $c .= '0D';     // TIMEZONE 00..23h WHERE 12=GMT  13=ROME
        $c .= '1';      // ENABLE DTS 0=DISABLED  1=ENABLED
        $c .= '012C';   // SERVER POLLING TIME : 12C => 300 SECONDS => 5 MINUTES
        $c .= '1';      // TRANSIT DIRECTION 1=ENTRANCE 2=EXIT
        return $c;
    }

    // GET THE REMOTE CLIENT PUBLIC IP
    private function getClientIP()
    {
        if (isset($_SERVER)) {

            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                return $_SERVER["HTTP_X_FORWARDED_FOR"];
            }

            if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                return $_SERVER["HTTP_CLIENT_IP"];
            }

            if (isset($_SERVER["REMOTE_ADDR"])) {
                return $_SERVER["REMOTE_ADDR"];
            }
        }

        if (getenv('HTTP_X_FORWARDED_FOR')) {
            return getenv('HTTP_X_FORWARDED_FOR');
        }

        if (getenv('HTTP_CLIENT_IP')) {
            return getenv('HTTP_CLIENT_IP');
        }

        return getenv('REMOTE_ADDR');
    }


    // CREATE DEVICE HEADER FOR LCD MESSAGE
    public function HeaderMsg($ForeColor, $BackColor, $IdIcon)
    {
        return '#'.sprintf('%6s', str_replace('#', '', $ForeColor)).sprintf('%6s',
                str_replace('#', '', $BackColor)).sprintf('%02X', $IdIcon);
    }


    // Convert HEX String To String
    public function HexToStr($hex)
    {
        $str = '';
        for ($i = 0; $i < strlen($hex); $i += 2) {
            $ord = hexdec(substr($hex, $i, 2));
            $str .= chr($ord);
        }
        return mb_convert_encoding($str, 'UTF-8', 'ISO-8859-1');
        //return (utf8_encode($str));
    }

    // Convert String To HEX String
    public function StrToHex($string)
    {
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0'.$hexCode, -2);
        }
        return $this->_localDebug ? $string : strToUpper($hex);
    }


    /*
    ** LOOK FOR DEVICE PINCODE INSIDE DB
    */
    private function _identifyIdDevice($PinCode = '')
    {
        // LOOK FOR DEVICE PINCODE INSIDE YOUR DB
        //
        // ....
        $this->IdPlant = 189;
        $this->IdReader = 1;
        //
        return true;        // True = Device Found  False = Device Not Found
    }

    private function _setPinAndMsg($DevicePin, $IdRtxMsg)
    {
        $this->_devicePin = $DevicePin;
        $this->_idRtxMsg = $IdRtxMsg;
    }

    public function getXmlResponse()
    {
        $response = [
            'TermInfo' => [
                'IDM' => $this->_idRtxMsg,
                'PIN' => $this->_devicePin,
                'UTC' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        ];

        if ($this->_answErrCode > 0) {
            // ERROR ANSWER
            $response['TermInfo']['ERR'] = $this->_answErrCode;
            $response['TermInfo']['MSG'] = $this->_answMsg;

        } else {
            // ANSWER TO COMMAND
            if ($this->_readerCmd > 0) {
                $response['TermInfo']['CMD'] = $this->_readerCmd;
            }
            // ANSWER DATA : TermData {}
            if ($this->_answCmd > 0 & $this->_answCmd < 1000) {
                if (strlen($this->_answCmd) > 0) {
                    $response['TermData']['AWC'] = $this->_answCmd;
                }
                if (strlen($this->_answData) > 0) {
                    $response['TermData']['DAT'] = $this->_answData;
                }
                if (strlen($this->_answMsg) > 0) {
                    $response['TermData']['MSG'] = $this->_debug ? $this->_hex2str($this->_answMsg) : $this->_answMsg;
                }
                if (strlen($this->_answLed) > 0) {
                    $response['TermData']['LED'] = $this->_answLed;
                }
                if (strlen($this->_answSetup) > 0) {
                    $response['TermData']['TMS'] = $this->_answSetup;
                }
                if (strlen($this->_answMifare) > 0) {
                    $response['TermData']['MFS'] = $this->_answMifare;
                }
                if (strlen($this->_answBarcode) > 0) {
                    $response['TermData']['BCS'] = $this->_answBarcode;
                }
                if (strlen($this->_answNewFrw) > 0) {
                    $response['TermData']['FWU'] = $this->_answNewFrw;
                }
            }
        }

        return ArrayToXml::convert($response, 'Terminal');
    }


    public function setLocalDebug($value)
    {
        $this->_localDebug = $value;
    }

    public function setTransitError($message)
    {
        $this->_setError($message);
        $this->_setAnswerCmd(self::AWC_ACT_TRN);
    }

    public function setTransitSuccess($message)
    {
        $this->_setSuccess($message);
        $this->_setAnswerCmd(self::AWC_ACT_TRN);
    }

    public function setTransitWarning($message)
    {
        $this->_setWarning($message);
        $this->_setAnswerCmd(self::AWC_ACT_TRN);
    }


    public function setReaderError($message)
    {
        $this->_setError($message);
        $this->_setAnswerCmd(self::AWC_RDR_TRN);
    }

    public function setReaderSuccess($message)
    {
        $this->_setSuccess($message);
        $this->_setAnswerCmd(self::AWC_RDR_TRN);
    }

    public function setReaderWarning($message)
    {
        $this->_setWarning($message);
        $this->_setAnswerCmd(self::AWC_RDR_TRN);
    }


    private function _setError($message)
    {
        // DISPLAY
        $ColorText = '#FFFFFF';     // RGB - WHITE TEXT
        $ColorBack = '#FF0000';     // RGB - RED BACK

        // RGB LED
        $LedBlink = 0;           // 0=NoBlink / 1=Blink
        $LedTime = 3;           // Led Time 3 Sec
        $LedRGBcolor = '#FFFF00';   // RGB - RED

        // DATA
        $_answDatas['enabling_open_gate'] = 0;
        $_answDatas['number_of_beeps'] = 4;

        $this->_setAnswer($ColorText, $ColorBack, $message, $LedRGBcolor, $LedBlink, $LedTime, $_answDatas);
        return;
    }

    private function _setSuccess($message)
    {
        // DISPLAY
        $ColorText = '#FFFFFF';     // RGB - WHITE TEXT
        $ColorBack = '#00FF00';     // RGB - RED BACK

        // LED
        $LedBlink = 0;           // 0=NoBlink / 1=Blink
        $LedTime = 3;           // Led Time 3 Sec
        $LedRGBcolor = '#FFFF00';   // RGB - RED

        // DATA
        $_answDatas['enabling_open_gate'] = 1;
        $_answDatas['number_of_beeps'] = 2;
        $_answDatas['enabling_relais_1'] = 1;
        $_answDatas['number_of_allowed_entrance'] = 1;

        $this->_setAnswer($ColorText, $ColorBack, $message, $LedRGBcolor, $LedBlink, $LedTime, $_answDatas);
        return;
    }

    private function _setWarning($message)
    {
        // DISPLAY
        $ColorText = '#000000';     // RGB - WHITE TEXT
        $ColorBack = '#FFCC00';     // RGB - RED BACK

        // LED
        $LedRGBcolor = '#FFFF00';   // RGB - RED
        $LedBlink = 0;           // 0=NoBlink / 1=Blink
        $LedTime = 3;           // Led Time 3 Sec

        // DATA
        $_answDatas['enabling_open_gate'] = 0;
        $_answDatas['number_of_beeps'] = 4;

        $this->_setAnswer($ColorText, $ColorBack, $message, $LedRGBcolor, $LedBlink, $LedTime, $_answDatas);
        return;
    }

    private function _setAnswer($ColorText, $ColorBack, $message, $LedRGBcolor, $LedBlink, $LedTime, $answDatas)
    {

        $this->_log("Message".$message);

        $this->_answMsg = $this->HeaderMsg($ColorText, $ColorBack, 0).$this->StrToHex("^".$message);
        $this->_answLed = sprintf('%1X', $LedBlink).sprintf('%02X', $LedTime).sprintf('%-7s', $LedRGBcolor);

        // DATA
        $this->_answData .= sprintf('%01X',
            isset($answDatas['enabling_open_gate']) ? $answDatas['enabling_open_gate'] : 0);                // 0/1 Enabling Open Gate
        $this->_answData .= sprintf('%01X',
            isset($answDatas['allow_double_card_reading']) ? $answDatas['allow_double_card_reading'] : 0);         // 0/1 Allow double Card Reading
        $this->_answData .= sprintf('%02X',
            isset($answDatas['number_of_allowed_entrance']) ? $answDatas['number_of_allowed_entrance'] : 0);        // 0/1..99 Number of Allowed Entrance
        $this->_answData .= sprintf('%02X',
            isset($answDatas['enabling_relais_1']) ? $answDatas['enabling_relais_1'] : 0);                 // Enabling Relais n.1 time 0,1,2,3 sec
        $this->_answData .= sprintf('%02X',
            isset($answDatas['enabling_relais_2']) ? $answDatas['enabling_relais_2'] : 0);                 // Enabling Relais n.2 time 0,1,2,3 sec
        $this->_answData .= sprintf('%02X',
            isset($answDatas['enabling_relais_3']) ? $answDatas['enabling_relais_3'] : 0);                 // Enabling Relais n.3 time 0,1,2,3 sec
        $this->_answData .= sprintf('%02X',
            isset($answDatas['enabling_relais_4']) ? $answDatas['enabling_relais_4'] : 0);                 // Enabling Relais n.4 time 0,1,2,3 sec
        $this->_answData .= sprintf('%02X',
            isset($answDatas['number_of_beeps']) ? $answDatas['number_of_beeps'] : 0);                                               // Number of Beeps
        $this->_answData .= sprintf('%02X',
            isset($answDatas['number_of_voice']) ? $answDatas['number_of_voice'] : 0);     // Number of Voice Message
        $this->_answData .= sprintf('%02X',
            isset($answDatas['lock_card_reader_for_seconds']) ?: 60);                    // Lock Card Reader for xx/10 Sec. (30 = 3 Sec.)
    }

    private function _setAnswerCmd($cmd)
    {
        $this->_answCmd = $cmd;
    }

    public function setPlantAndReader($plant, $reader)
    {
        $this->_idPlant = $plant;
        $this->_idReader = $reader;

    }

    private function _setDeviceStatus($pollingData)
    {
        switch ($pollingData) {
            case self::DAT_PLL_APM:
                $this->_deviceStatus = self::DEVICE_STATUS_PANIC_MODE;
                break;
            case self::DAT_PLL_OPR:
                $this->_deviceStatus = self::DEVICE_STATUS_OPERATIVE;
                break;
            default:
                $this->_deviceStatus = null;
                break;
        }
    }

    public function getDeviceStatus()
    {
        return $this->_deviceStatus;
    }

    private function _log($log)
    {
        if (self::DEBUG) {
            Log::debug($log);
        }
    }

    private function _hex2str($hex)
    {
        $str = '';
        $hex = substr($hex, 13);
        for ($i = 0; $i < strlen($hex); $i += 2) {
            $str .= chr(hexdec(substr($hex, $i, 2)));
        }
        return $str;
    }

}
