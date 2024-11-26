<?php

namespace App\Services;
use App\Models\Product;
use App\Models\ProductValidity;
use App\Models\Service;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/*
Mancante:
- IVA preassolta
- Prevendita?

Da inserire a mano:
    - cod_location_siae su site
*/

class SiaeService
{

    public function getToken(){
        $url = env('TICKA_API_URL').'/Account/GetToken';
        $username = env('TICKA_USERNAME');
        $password = env('TICKA_PASSWORD');

        $data = array(
            'userName' => $username,
            'password' => $password
        );

        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
                'ignore_errors' => false
            )
        );
        $context = stream_context_create($options);

        $response = json_decode(@file_get_contents($url, false, $context));

        return $response->token;

    }

    public function getEventi($token, $site_id, $start_date, $end_date){

        $site = Site::find($site_id);
        $url = env('TICKA_API_URL').'/Evento/Eventi';
        if($site->cod_location_siae != null){
            $params = http_build_query([
                'periodoInizio' => $start_date,
                'periodoFine' => $end_date,
                'codiceLocale' => $site->cod_location_siae,
            ]);

            $url .= '?' . $params;
            $options = array(
                'http' => array(
                    'header'  => "Authorization: Bearer $token\r\n" .
                                "Content-Type: application/json\r\n",
                    'method'  => 'GET',
                    'ignore_errors' => false
                )
            );
            $context = stream_context_create($options);

            $eventi = json_decode(@file_get_contents($url, false, $context));
            Log::info($eventi);
            foreach($eventi as $evento) {
                $spettacolo = $this->getSpettacolo($token, $evento->spettacoloId);

                if ($spettacolo) {

                    $service = Service::updateOrCreate(
                        ['code' => $spettacolo->id],
                        [
                            'name' => $spettacolo->titolo,
                            'description' => $spettacolo->descrizioneAggiuntiva,
                            'slug' => strtolower(str_replace(" ", "-", $spettacolo->titolo)),
                            'product_category_id' => 7,
                            'is_siae' => 1,
                            'site_id' => $site_id,
                            'code' => $spettacolo->id // id spettacolo di ticka
                        ]
                    );

                    $ordini_posto = $this->getOrdiniPosto($token, $evento->id);

                    //Log::info($ordini_posto);
                    if ($ordini_posto) {

                        foreach($ordini_posto as $ordine_posto) {
                            $codici_riduzione = $this->getCodiciRiduzione($token, $evento->id, $ordine_posto->codice);
                            $codici_riduzione_online = $this->getCodiciRiduzioneOnline($token, $evento->id, $ordine_posto->codice, $visibilita = 1);

                            if(isset($codici_riduzione_online)){
                                $codici_riduzione_online_codes = array_map(function($item) {
                                    return $item->codice;
                                }, $codici_riduzione_online);
                            }else{
                                $codici_riduzione_online_codes = array();
                            }

                            if ($codici_riduzione) {
                                foreach($codici_riduzione as $riduzione) {

                                    $prezzo = $this->getPrezzo($token, $evento->id, $ordine_posto->codice, $riduzione->codice);
                                    if ($prezzo) {
                                        $isOnline = in_array($riduzione->codice, $codici_riduzione_online_codes);

                                        $product = Product::updateOrCreate(
                                            [
                                                'cod_riduzione_siae' => $riduzione->codice,
                                                'cod_ordine_posto' => $ordine_posto->codice,
                                                'code' => $evento->id,
                                                'service_id' => $service->id
                                            ],
                                            [
                                                'name' => $ordine_posto->descrizione . " - " . ($riduzione->descrizionePersonalizzata !== null ? $riduzione->descrizionePersonalizzata : $riduzione->descrizione),
                                                //'slug' => strtolower(str_replace(" ", "-", $ordine_posto->descrizione . " " . ($riduzione->descrizionePersonalizzata !== null ? $riduzione->descrizionePersonalizzata : $riduzione->descrizione))),
                                                'slug' => $service->slug,
                                                'deliverable' => 1,
                                                'service_id' => $service->id,
                                                'code' => $evento->id,
                                                'price_sale' => $prezzo->prezzo,
                                                'price_web' => $prezzo->prezzo,
                                                'vat' => $prezzo->percIva,
                                                'is_siae' => 1,
                                                'cod_ordine_posto' => $ordine_posto->codice,
                                                'cod_riduzione_siae' => $riduzione->codice,
                                                'validity_from_issue_unit' => 'days',
                                                'validity_from_issue_value' => 1,
                                                'validity_from_burn_unit' => 'days',
                                                'validity_from_burn_value' => 1,
                                                'date_event' => Carbon::parse($evento->inizio)->format('Y-m-d H:i:s'),
                                                'matrix_generation_type' => 'on_request',
                                                'sale_matrix' => [
                                                    "schools" => [
                                                        "crm" => null,
                                                        "tvm" => null,
                                                        "online" => $isOnline,
                                                        "onsite" => true
                                                    ],
                                                    "agencies" => [
                                                        "crm" => null,
                                                        "tvm" => null,
                                                        "online" => $isOnline,
                                                        "onsite" => true
                                                    ],
                                                    "customers" => [
                                                        "crm" => null,
                                                        "tvm" => null,
                                                        "online" => $isOnline,
                                                        "onsite" => true
                                                    ]
                                                ],
                                                'price_purchase' => 0 // da verificare
                                            ]
                                        );

                                        ProductValidity::where('product_id', $product->id)->delete();
                                        ProductValidity::create(
                                            [
                                                'product_id' => $product->id,
                                                'start_validity' => date('Y-m-d H:i:s'),
                                                'end_validity' => Carbon::parse($evento->fine)->format('Y-m-d H:i:s'),
                                            ]
                                        );

                                        $productService = new ProductService($product);
                                        $productService->createVirtualStoreSettingsRelationShip($riduzione->descrizione);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    private function getSpettacolo($token, $spettacoloId) {
        $url = env('TICKA_API_URL').'/Evento/Spettacolo';
        $params = http_build_query([
            'spettacoloId' => $spettacoloId
        ]);
        $url .= '?' . $params;

        $options = array(
            'http' => array(
                'header'  => "Authorization: Bearer $token\r\n" .
                            "Content-Type: application/json\r\n",
                'method'  => 'GET',
                'ignore_errors' => false
            )
        );
        $context = stream_context_create($options);

        $spettacolo = json_decode(@file_get_contents($url, false, $context));

        return $spettacolo;
    }

    private function getOrdiniPosto($token, $eventoId) {

        $url = env('TICKA_API_URL').'/Evento/OrdinePosto';
        $params = http_build_query([
            'eventoId' => $eventoId
        ]);
        $url .= '?' . $params;
        $options = array(
            'http' => array(
                'header'  => "Authorization: Bearer $token\r\n" .
                            "Content-Type: application/json\r\n",
                'method'  => 'GET',
                'ignore_errors' => false
            )
        );
        $context = stream_context_create($options);
        $ordini_posto = json_decode(@file_get_contents($url, false, $context));
        return $ordini_posto;
    }

    private function getCodiciRiduzione($token, $eventoId, $codiceOrdinePosto) {
        $url = env('TICKA_API_URL').'/Evento/CodiciRiduzione';

        // Visibility. 0: ticketing, 1: online, 2: both
        $params = http_build_query([
            'eventoId' => $eventoId,
            'codiceOrdinePosto' => $codiceOrdinePosto
        ]);
        $url .= '?' . $params;

        $options = array(
            'http' => array(
                'header'  => "Authorization: Bearer $token\r\n" .
                            "Content-Type: application/json\r\n",
                'method'  => 'GET',
                'ignore_errors' => false
            )
        );
        $context = stream_context_create($options);

        $codici_riduzione = json_decode(@file_get_contents($url, false, $context));

        return $codici_riduzione;
    }


    private function getCodiciRiduzioneOnline($token, $eventoId, $codiceOrdinePosto) {
        $url = env('TICKA_API_URL').'/Negozio/getCodiciriduzioneBigliettoOnLine';

        // Visibility. 0: ticketing, 1: online, 2: both
        $params = http_build_query([
            'negozioId' => env("TICKA_ADITUS_STORE_ID"),
            'eventoId' => $eventoId,
            'codiceOrdinePosto' => $codiceOrdinePosto
        ]);
        $url .= '?' . $params;

        $options = array(
            'http' => array(
                'header'  => "Authorization: Bearer $token\r\n" .
                            "Content-Type: application/json\r\n",
                'method'  => 'GET',
                'ignore_errors' => false
            )
        );
        $context = stream_context_create($options);

        $codici_riduzione = json_decode(@file_get_contents($url, false, $context));

        return $codici_riduzione;
    }

    private function getPrezzo($token, $eventoId, $codiceOrdinePosto, $riduzioneCodice) {
        $url = env('TICKA_API_URL').'/Evento/Prezzo';
        $params = http_build_query([
            'eventoId' => $eventoId,
            'codiceOrdinePosto' => $codiceOrdinePosto,
            'riduzioneCodice' => $riduzioneCodice
        ]);
        $url .= '?' . $params;

        $options = array(
            'http' => array(
                'header'  => "Authorization: Bearer $token\r\n" .
                            "Content-Type: application/json\r\n",
                'method'  => 'GET',
                'ignore_errors' => false
            )
        );
        $context = stream_context_create($options);

        $prezzo = json_decode(@file_get_contents($url, false, $context));

        return $prezzo;
    }

    public function getDisponibilitaOrdinePosto($cod_product, $code_ordine_posto){

        $token = self::getToken();
        $url = env('TICKA_API_URL').'/Evento/DisponibilitaOrdinePosto';
        $params = http_build_query([
            'eventoId' => $cod_product,
            'codiceOrdinePosto' => $code_ordine_posto,
        ]);

        $url .= '?' . $params;

        $options = array(
            'http' => array(
                'header'  => "Authorization: Bearer $token\r\n" .
                            "Content-Type: application/json\r\n",
                'method'  => 'GET',
                'ignore_errors' => false
            )
        );
        $context = stream_context_create($options);

        $posti = json_decode(@file_get_contents($url, false, $context));
        if(isset($posti->disponibilita) ){
            return $posti->disponibilita;
        }else{
            return 0;
        }
    }

    private function verificaPerIngresso($token, $eventoId, $codiceElettronico){
        $url = env('TICKA_API_URL').'/ControlloAccessi/VerificaPerIngresso';
        $params = http_build_query([
            'eventoId' => $eventoId,
            'codiceElettronico' => $codiceElettronico,
        ]);
        $url .= '?' . $params;

        $options = array(
            'http' => array(
                'header'  => "Authorization: Bearer $token\r\n" .
                            "Content-Type: application/json\r\n",
                'method'  => 'GET',
                'ignore_errors' => false
            )
        );
        $context = stream_context_create($options);

        $check = json_decode(@file_get_contents($url, false, $context));

        return $check;
    }


    public function verificaPerIngressoTornello($eventoId, $codiceElettronico){
        $token = self::getToken();
        $url = env('TICKA_API_URL').'/ControlloAccessi/VerificaPerIngresso';
        $params = http_build_query([
            'eventoId' => $eventoId,
            'codiceElettronico' => $codiceElettronico,
        ]);
        $url .= '?' . $params;

        $options = array(
            'http' => array(
                'header'  => "Authorization: Bearer $token\r\n" .
                            "Content-Type: application/json\r\n",
                'method'  => 'GET',
                'ignore_errors' => false
            )
        );
        $context = stream_context_create($options);

        $check = json_decode(@file_get_contents($url, false, $context));

        return $check;
    }

    public function ingressoEffettuatoTornelli($eventoId, $codiceElettronico){
        $token = self::getToken();

        $url = env('TICKA_API_URL').'/ControlloAccessi/IngressoEffettuato';

        $data = array(
            "eventoId" => $eventoId,
            "codiceElettronico" => $codiceElettronico
        );
        $options = array(
            'http' => array(
                'header'  => "Authorization: Bearer $token\r\n" .
                            "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
                'ignore_errors' => false
            )
        );
        $context = stream_context_create($options);

        $ingresso = json_decode(@file_get_contents($url, false, $context));
        return ($ingresso->esito) ? true : $ingresso->messaggio;

    }


    public function ingressoEffettuato($eventoId, $codiceElettronico){
        $token = self::getToken();
        $checkIngresso = self::verificaPerIngresso($token, $eventoId, $codiceElettronico);
        if($checkIngresso->esito){

            $url = env('TICKA_API_URL').'/ControlloAccessi/IngressoEffettuato';

            $data = array(
                "eventoId" => $eventoId,
                "codiceElettronico" => $codiceElettronico
            );
            $options = array(
                'http' => array(
                    'header'  => "Authorization: Bearer $token\r\n" .
                                "Content-Type: application/json\r\n",
                    'method'  => 'POST',
                    'content' => json_encode($data),
                    'ignore_errors' => false
                )
            );
            $context = stream_context_create($options);

            $ingresso = json_decode(@file_get_contents($url, false, $context));
            return ($ingresso->esito) ? true : $ingresso->messaggio;

        }else{
            return $checkIngresso->messaggio;
        }
    }

    public function emettiBiglietto($order_item){

        $token = self::getToken();
        $url = env('TICKA_API_URL').'/Biglietto/Emetti';

        if(self::getDisponibilitaOrdinePosto($order_item->product->code, $order_item->product->cod_ordine_posto) > 0){
            foreach($order_item->scans AS $scan){

                $modelloBiglietto = array(
                    "ordinepostoCodice" => $order_item->product->cod_ordine_posto,
                    "riduzioneCodice" => $order_item->product->cod_riduzione_siae,
                    "prevendita" => false, // ??
                    "ivaPreassolta" => "B", // ??
                    "operatorId" => auth()->user()->siae_operator_id,
                    "terminaleId" => $order_item->order->cashier->siae_terminal_id,
                    "codiceSupporto" => "BT",
                    "codiceElettronico" => $scan->qr_code,
                    "eventoId" => $order_item->product->code,
                );
                $identificativoTransazione = $scan->virtual_store_matrix_id;

                $data = array(
                    "modelloBiglietto" => $modelloBiglietto,
                    "identificativoTransazione" => (string)$identificativoTransazione
                );
                $options = array(
                    'http' => array(
                        'header'  => "Authorization: Bearer $token\r\n" .
                                    "Content-Type: application/json\r\n",
                        'method'  => 'POST',
                        'content' => json_encode($data),
                        'ignore_errors' => false
                    )
                );
                $context = stream_context_create($options);
                $response = json_decode(@file_get_contents($url, false, $context));

            }
            $print = self::stampaTitolo($token, $order_item->product->code, $order_item->product->cod_ordine_posto, $response->id, $order_item->order->cashier->siae_terminal_id);

            return true;
        }else{
            return -1;
        }
    }

    public function emettiBigliettoOnline($order_item, $lang = "it"){
        $token = self::getToken();
        $url = env('TICKA_API_URL').'/Biglietto/Emetti';
        $terminaleId = env('TICKA_ADITUS_TERMINAL_ID');
        $operatorId = env('TICKA_ADITUS_OPERATOR_ID');

        if(self::getDisponibilitaOrdinePosto($order_item->product->code, $order_item->product->cod_ordine_posto) > 0){
            Log::info('a1');
            foreach($order_item->scans AS $scan){
                Log::info('aa2');

                $modelloBiglietto = array(
                    "ordinepostoCodice" => $order_item->product->cod_ordine_posto,
                    "riduzioneCodice" => $order_item->product->cod_riduzione_siae,
                    "prevendita" => false, // ??
                    "ivaPreassolta" => "B", // ??
                    "operatorId" => $operatorId,
                    "terminaleId" => $terminaleId,
                    "codiceSupporto" => "BT",
                    "codiceElettronico" => $scan->qr_code,
                    "eventoId" => $order_item->product->code,
                );
                $identificativoTransazione = $scan->virtual_store_matrix_id;

                Log::info($modelloBiglietto);
                $data = array(
                    "modelloBiglietto" => $modelloBiglietto,
                    "identificativoTransazione" => (string)$identificativoTransazione
                );
                Log::info($data);
                $options = array(
                    'http' => array(
                        'header'  => "Authorization: Bearer $token\r\n" .
                                    "Content-Type: application/json\r\n",
                        'method'  => 'POST',
                        'content' => json_encode($data),
                        'ignore_errors' => false
                    )
                );
                $context = stream_context_create($options);
                Log::info($data);

                try {
                    $response = json_decode(@file_get_contents($url, false, $context));
                    $print = self::inviaTitolo($token, $order_item->product->code, $order_item->product->cod_ordine_posto, $response->id, $terminaleId, $order_item->order, $lang);
                } catch (\Exception $e) {
                    http_response_code(500);
                }

            }

            return true;
        }else{
            return -1;
        }
    }


    public function stampaTitolo($token, $eventoId, $cod_ordine_posto, $titoloId, $terminaleId){

        $url = env('TICKA_API_URL').'/Titolo/Stampa';

        $ordini_posto = self::getOrdiniPosto($token, $eventoId);

        $ordinepostoDescrizione = "";
        foreach ($ordini_posto as $ordine) {
            if ($ordine->codice === $cod_ordine_posto) {
                $ordinepostoDescrizione = $ordine->descrizione;
                break;
            }
        }

        $data = array(
            "titoloId" => $titoloId,
            "terminaleId" => $terminaleId,
            "background" => "blue",
            "ordinepostoDescrizione" => $ordinepostoDescrizione,
            "tipoAbbonamentoLabel" => ""
        );

        $options = array(
            'http' => array(
                'header'  => "Authorization: Bearer $token\r\n" .
                            "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
                'ignore_errors' => false
            )
        );

        $context = stream_context_create($options);
        $stampa = json_decode(@file_get_contents($url, false, $context));
        return $stampa;
    }

    public function inviaTitolo($token, $eventoId, $cod_ordine_posto, $titoloId, $terminaleId, $order, $lang)
    {
        $url = env('TICKA_API_URL').'/Titolo/InviaEmail';

        $ordini_posto = self::getOrdiniPosto($token, $eventoId);

        Log::info('aa13');
        $ordinepostoDescrizione = "";
        foreach ($ordini_posto as $ordine) {
            if ($ordine->codice === $cod_ordine_posto) {
                $ordinepostoDescrizione = $ordine->descrizione;
                break;
            }
        }

        $data = array(
            "titoloId" => $titoloId,
            "terminaleId" => $terminaleId,
            "background" => "blue",
            "ordinepostoDescrizione" => $ordinepostoDescrizione,
            "tipoAbbonamentoLabel" => 'string',
            "emailTo" => $order->user->email,
            "emailSubject" => ($lang == "en" ? "Order Confirmation" : "Conferma Ordine") . " #" . $order->order_number,
            "emailBody" => "aaaaaaaaa"
        );
        Log::info($data);
        //$message->from('info@aditusculture.com', 'Aditus S.r.l.');
        $options = array(
            'http' => array(
                'header'  => "Authorization: Bearer $token\r\n" .
                            "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
                'ignore_errors' => false
            )
        );

        Log::info('aaaa1');
        $context = stream_context_create($options);
        $stampa = json_decode(@file_get_contents($url, false, $context));

        Log::info($stampa);
        return $stampa;
    }



}
