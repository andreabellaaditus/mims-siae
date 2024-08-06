<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use App\Models\Site;
use App\Services\SiaeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="AditusAPI", version="1.0")
 * @OA\SecurityScheme(
 *     type="http",
 *     in="header",
 *     securityScheme="Authentication",
 *     name="Authorize"
 * )
 */

class ProductsController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/sites",
     *     summary="Get all sites",
     *     tags={"Sites"},
     *     security={ {"Authentication": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Sites retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Sites retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="pole_id", type="integer", example=1),
     *                     @OA\Property(property="company_id", type="integer", example=1),
     *                     @OA\Property(property="concession_id", type="integer", nullable=true, example=null),
     *                     @OA\Property(property="unlock_matrix_pole_id", type="integer", example=3),
     *                     @OA\Property(property="slug", type="string", example="neapolis"),
     *                     @OA\Property(property="name", type="string", example="Parco Archeologico della Neapolis"),
     *                     @OA\Property(property="canonical_name", type="string", example="parco-archeologico-della-neapolis"),
     *                     @OA\Property(property="address", type="string", example="Via Paradiso, 14, 96100 Siracusa SR, Italia"),
     *                     @OA\Property(property="city", type="string", example="Siracusa"),
     *                     @OA\Property(property="region", type="string", example="Sicilia"),
     *                     @OA\Property(property="lat", type="string", example="37.0741229"),
     *                     @OA\Property(property="lng", type="string", example="15.2788834"),
     *                     @OA\Property(property="is_comingsoon", type="boolean", example=false),
     *                     @OA\Property(property="is_closed", type="boolean", example=false),
     *                     @OA\Property(property="in_concession", type="boolean", example=true),
     *                     @OA\Property(property="matrix_suffix", type="string", example="N"),
     *                     @OA\Property(property="access_control_enabled", type="boolean", example=true),
     *                     @OA\Property(property="poll_enabled", type="boolean", example=false),
     *                     @OA\Property(property="cashier_fee_enabled", type="boolean", example=true),
     *                     @OA\Property(property="tvm", type="boolean", example=false),
     *                     @OA\Property(property="onsite_auto_scan", type="boolean", example=false),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2017-10-09T07:52:45.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-05-30T15:25:12.000000Z"),
     *                     @OA\Property(property="cod_location_siae", type="string", nullable=true, example="1234567687894")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve sites",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to retrieve sites: Internal Server Error")
     *         )
     *     )
     * )
     */

    public function getSites(){

        return response()->json([
            'success' => true,
            'message' => 'Sites retrieved successfully',
            'data' => Site::all()
        ]);
    }

    /**
         * @OA\Get(
         *     path="/api/services/{product_category}/{site?}",
         *     summary="Get list of active services",
         *     tags={"Services"},
         *     security={ {"Authentication": {} }},
         *     @OA\Parameter(
         *         name="product_category",
         *         in="path",
         *         required=true,
         *         @OA\Schema(type="string"),
         *         description="Slug of the product category"
         *     ),
         *     @OA\Parameter(
         *         name="site",
         *         in="path",
         *         required=false,
         *         @OA\Schema(type="string"),
         *         description="Slug of the site"
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="List of services retrieved successfully",
         *         @OA\JsonContent(
         *             type="object",
         *             @OA\Property(property="success", type="boolean", example=true),
         *             @OA\Property(property="message", type="string", example="Services retrieved successfully"),
         *             @OA\Property(
         *                 property="data",
         *                 type="array",
         *                 @OA\Items(
         *                     @OA\Property(property="id", type="integer", example=1),
         *                     @OA\Property(property="name", type="string", example="Service Name"),
         *                     @OA\Property(property="description", type="string", example="Service Description"),
         *                     @OA\Property(property="site_id", type="integer", example=1),
         *                     @OA\Property(property="slug", type="string", example="service-name"),
         *                     @OA\Property(property="is_siae", type="boolean", example=true),
         *                     @OA\Property(
         *                         property="site",
         *                         type="object",
         *                         @OA\Property(property="id", type="integer", example=1),
         *                         @OA\Property(property="name", type="string", example="Site Name"),
         *                         @OA\Property(property="address", type="string", example="Site Address")
         *                     )
         *                 )
         *             )
         *         )
         *     ),
         *     @OA\Response(
         *         response=500,
         *         description="Failed to retrieve services",
         *         @OA\JsonContent(
         *             type="object",
         *             @OA\Property(property="success", type="boolean", example=false),
         *             @OA\Property(property="message", type="string", example="Failed to retrieve services: Internal Server Error")
         *         )
         *     )
         * )
         */
    public function getServices($product_category_slug, $site_slug = null)
    {
        try {
            $today = date('Y-m-d H:i:s');

            $servicesQuery = Service::where('active', 1)
                ->whereHas('products', function ($query) use ($today) {
                    $query->whereHas('product_validities', function ($query) use ($today) {
                        $query->where('start_validity', '<=', $today)
                            ->where('end_validity', '>=', $today);
                    });
                })
                ->whereHas('product_category', function ($query) use ($product_category_slug) {
                    $query->where('slug', $product_category_slug);
                });

            if ($site_slug) {
                $servicesQuery->whereHas('site', function ($query) use ($site_slug) {
                    $query->where('slug', $site_slug);
                });
            }

            $services = $servicesQuery->with('site:id,name,address')
                ->get(['id', 'name', 'description', 'site_id', 'slug', 'is_siae']);

            return response()->json([
                'success' => true,
                'message' => 'Services retrieved successfully',
                'data' => $services
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve services: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * @OA\Get(
     *     path="/api/services/{slug}/{type}/products",
     *     summary="Get products for a specific service and type",
     *     tags={"Products"},
     *     security={ {"Authentication": {} }},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug of the service",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="path",
     *         required=true,
     *         description="Type of user receiving the products (customers, travel-agencies, schools)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="is_siae",
     *         in="query",
     *         required=true,
     *         description="Filter products based on the is_siae field. Default is 0.",
     *         @OA\Schema(
     *             type="integer",
     *             example=0
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Products retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="service",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Service Name"),
     *                     @OA\Property(property="description", type="string", example="Service Description"),
     *                     @OA\Property(property="slug", type="string", example="service-slug")
     *                 ),
     *                 @OA\Property(
     *                     property="products",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Product Name"),
     *                         @OA\Property(property="price_sale", type="string", example="123.45"),
     *                         @OA\Property(property="cod_ordine_posto", type="string", example="ABCDE"),
     *                         @OA\Property(property="cod_riduzione_siae", type="string", example="12345"),
     *                         @OA\Property(property="is_siae", type="integer", example=1),
     *                         @OA\Property(
     *                             property="reductions",
     *                             type="array",
     *                             @OA\Items(
     *                                 @OA\Property(property="id", type="integer", example=1),
     *                                 @OA\Property(property="name", type="string", example="Reduction Name")
     *                             )
     *                         ),
     *                         @OA\Property(
     *                             property="reduction_fields",
     *                             type="array",
     *                             @OA\Items(
     *                                 @OA\Property(property="id", type="integer", example=1),
     *                                 @OA\Property(property="name", type="string", example="Reduction Field Name"),
     *                                 @OA\Property(property="slug", type="string", example="reduction-field-slug")
     *                             )
     *                         ),
     *                         @OA\Property(
     *                             property="shows",
     *                             type="array",
     *                             @OA\Items(
     *                                 @OA\Property(property="date_event", type="string", example="2024-07-15"),
     *                                 @OA\Property(property="eventoId", type="string", example="ABCDE"),
     *                                 @OA\Property(property="availability", type="integer", example=10),
     *                                 @OA\Property(property="product_id", type="integer", example=1)
     *                             )
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Service not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to retrieve data: Internal Server Error")
     *         )
     *     )
     * )
     */
     public function getProducts($slug, $type, $is_siae = 0)
     {
         try {
             $service = Service::select('id', 'name', 'description', 'slug')
                         ->where('slug', $slug)
                         ->first();

             if (!$service) {
                 return response()->json([
                     'success' => false,
                     'message' => 'Service not found'
                 ], 404);
             }

             $today = date('Y-m-d H:i:s');
             $productsQuery = Product::with(['reductions', 'reduction_fields', 'related_products'])
                         ->where('service_id', $service->id)
                         ->whereHas('product_validities', function ($query) use ($today) {
                             $query->where('start_validity', '<=', $today)
                                 ->where('end_validity', '>=', $today);
                         })
                         ->whereJsonContains('sale_matrix->'.$type, ['online' => true])
                         ->where('is_siae', $is_siae);  // Aggiungiamo questo filtro

             $products = $productsQuery->get([
                 'id',
                 'name',
                 'price_sale',
                 'slug',
                 'service_id',
                 'code',
                 'date_event',
                 'cod_ordine_posto',
                 'is_date',
                 'is_hour',
                 'cod_riduzione_siae',
                 'check_document',
                 'is_siae'  // Assicurati di selezionare anche questo campo
             ]);

             $productData = [];
             $uniqueProducts = [];

             foreach ($products as $product) {
                 $priceSale = $product->price_sale;
                 foreach ($product->related_products as $related_prod) {
                     $product->name .= " + " . $related_prod->name;
                     $priceSale += $related_prod->price_sale;
                 }

                 $siaeService = new SiaeService();
                 $disponibilita = 1;
                 if($product->service->product_category->slug == 'site-events'){
                     $disponibilita = $siaeService->getDisponibilitaOrdinePosto($product->code, $product->cod_ordine_posto);
                 }

                 if($disponibilita > 0){
                     $uniqueKey = $product->name . '|' . $product->cod_ordine_posto . '|' . $product->cod_riduzione_siae;
                     if (!isset($uniqueProducts[$uniqueKey]) && !isset($productData[$product->id])) {
                         $uniqueProducts[$uniqueKey] = true;
                         $productData[$product->name] = [
                             'id' => $product->id,
                             'is_date' => $product->is_date,
                             'is_hour' => $product->is_hour,
                             'is_name' => $product->is_name,
                             'name' => $product->name,
                             'cod_ordine_posto' => $product->cod_ordine_posto,
                             'cod_riduzione_siae' => $product->cod_riduzione_siae,
                             'price_sale' => number_format($priceSale, 2, ",", "."),
                             'reductions' => $product->check_document ? $product->reductions->map(function ($reduction) {
                                 return [
                                     'id' => $reduction->id,
                                     'name' => $reduction->name,
                                 ];
                             }) : [],
                             'reduction_fields' => $product->check_document ? $product->reduction_fields->map(function ($reductionField) {
                                 return [
                                     'id' => $reductionField->id,
                                     'name' => $reductionField->name,
                                     'slug' => $reductionField->slug,
                                 ];
                             }) : []
                         ];
                     }
                     if($product->service->product_category->slug == 'site-events' && $product->date_event != null){
                         $productData[$product->name]['shows'][] = [
                             'date_event' => $product->date_event,
                             'eventoId' => $product->code,
                             'availability' => $disponibilita,
                             'product_id' => $product->id
                         ];
                     }
                 }
             }

             return response()->json([
                 'success' => true,
                 'message' => 'Data retrieved successfully',
                 'data' => [
                     'service' => $service,
                     'products' => array_values($productData)
                 ]
             ]);
         } catch (\Exception $e) {
             return response()->json([
                 'success' => false,
                 'message' => 'Failed to retrieve data: ' . $e->getMessage()
             ], 500);
         }
     }



    /**
     * @OA\Get(
     *     path="/api/evento/{eventoId}/ordineposto/{cod_ordine_posto}/disponibilita",
     *     summary="Get availability of an order position for an event",
     *     tags={"Events"},
     *     security={ {"Authentication": {} }},
     *     @OA\Parameter(
     *         name="eventoId",
     *         in="path",
     *         required=true,
     *         description="SIAE ID of the event",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="cod_ordine_posto",
     *         in="path",
     *         required=true,
     *         description="SIAE code of seat type ",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Availability retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Posti disponibili retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="disponibilita", type="integer", example=10)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve availability",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to retrieve availability: Internal Server Error")
     *         )
     *     )
     * )
     */

    public function getDisponibilitaOrdinePosto($eventoId, $cod_ordine_posto){

        $token = self::getToken();
        $url = env('TICKA_API_URL').'/Evento/DisponibilitaOrdinePosto';
        $params = http_build_query([
            'eventoId' => $eventoId,
            'codiceOrdinePosto' => $cod_ordine_posto,
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

        return response()->json([
            'success' => true,
            'message' => 'Posti disponibili retrieved successfully',
            'data' => [
                'disponibilita' => $posti->disponibilita
            ]
        ]);
    }

    public function emettiBiglietto($order_item){

        $token = self::getToken();
        $url = env('TICKA_API_URL').'/Biglietto/Emetti';

        if(self::getDisponibilitaOrdinePosto($order_item->product->code, $order_item->product->cod_ordine_posto) > 0){
            foreach($order_item->scans AS $scan){

                $modelloBiglietto = array(
                    "ordinepostoCodice" => $order_item->product->cod_ordine_posto,
                    "riduzioneCodice" => $order_item->product->cod_riduzione_siae,
                    "prevendita" => false,
                    "ivaPreassolta" => "B",
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
            self::stampaTitolo($token, $order_item->product->code, $order_item->product->cod_ordine_posto, $response->id, $order_item->order->cashier->siae_terminal_id);

            return true;
        }else{
            return -1;
        }
    }

    public function getToken(){
        $url = env('TICKA_API_URL').'/Account/GetToken';
        $username = 'User3';
        $password = 'AY2a#GfW!XB4L4@B';

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


}

