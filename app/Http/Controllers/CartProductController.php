<?php

namespace App\Http\Controllers;

use App\Services\SlotService;
use App\Models\{ Cart, CartProduct, Product, Service, Site, SiteHour};
use App\Http\Controllers\Controller;
use App\Http\Requests\CartProduct\{ DestroyManyRequest, StoreRequest };
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Http\Request;

class CartProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('logged-user');
    }

    /**
     * @OA\Get(
     *     path="/api/cart_products/cart",
     *     summary="Get cart products for the authenticated user",
     *     tags={"Cart Products"},
     *     security={ {"Authentication": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Cart products retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="cart_id", type="integer", example=1),
     *                     @OA\Property(property="product_id", type="integer", example=1),
     *                     @OA\Property(property="date_service", type="string", format="date-time", example="2024-07-15 10:00:00"),
     *                     @OA\Property(property="hour_service", type="string", example="10:00"),
     *                     @OA\Property(property="holder_last_name", type="string", example="Doe"),
     *                     @OA\Property(property="holder_first_name", type="string", example="John"),
     *                     @OA\Property(property="open_ticket", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="status", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve cart products",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="status", type="string", example="Internal Server Error")
     *         )
     *     )
     * )
     */

    public function index()
    {
        try {
            $cartProducts = CartProduct::select('id', 'cart_id', 'product_id', 'date_service', 'hour_service', 'holder_last_name', 'holder_first_name', 'open_ticket')
                ->whereHas('cart', function($query) {
                    $query->where('user_id', auth()->user()->id);
                })
                ->get();
        }
        catch (Throwable $e) {
            $error = $e->getMessage();
        }

        return collect([
            'success' => !isset($error),
            'status' => $error ?? 'success',
            'data' => isset($cartProducts) ? $this->getCartProductsResource($cartProducts, request('lang')) : []
        ]);
    }


    /**
     * @OA\Post(
     *     path="/api/cart_products/store",
     *     summary="Store cart products for the authenticated user",
     *     tags={"Cart Products"},
     *     security={ {"Authentication": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="products", type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="product_id", type="integer", example=1),
     *                     @OA\Property(property="date_service", type="string", format="date-time", example="2024-07-15 10:00:00"),
     *                     @OA\Property(property="hour_service", type="string", example="10:00"),
     *                     @OA\Property(property="holder_last_name", type="string", example="Doe"),
     *                     @OA\Property(property="holder_first_name", type="string", example="John"),
     *                     @OA\Property(property="open_ticket", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cart products stored successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="product_id", type="integer", example=1),
     *                     @OA\Property(property="date_service", type="string", format="date-time", example="2024-07-15 10:00:00"),
     *                     @OA\Property(property="hour_service", type="string", example="10:00"),
     *                     @OA\Property(property="holder_last_name", type="string", example="Doe"),
     *                     @OA\Property(property="holder_first_name", type="string", example="John"),
     *                     @OA\Property(property="open_ticket", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="status", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to store cart products",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="status", type="string", example="Internal Server Error")
     *         )
     *     )
     * )
     */
    public function store(StoreRequest $request)
    {
        try {
            $cartProducts = null;
            DB::transaction(function () use ($request, &$cartProducts) {
                $cart = Cart::firstOrCreate(['user_id' => auth()->user()->id]);

                // Check if products is a JSON string or already an array
                $products = is_string($request->products) ? json_decode($request->products) : $request->products;
                collect($products)
                    ->each(function($product) use ($cart) {
                        CartProduct::create([
                            'cart_id' => $cart->id,
                            'product_id' => $product['product_id'],
                            'date_service' => $product['date_service'] ?? null,
                            'hour_service' => isset($product['hour_service']) ? $product['hour_service'].':00' : null,
                            'holder_last_name' => isset($product['holder_last_name']) ? $product['holder_last_name'] : null,
                            'holder_first_name' => isset($product['holder_first_name']) ? $product['holder_first_name'] : null,
                            'open_ticket' => $product['open_ticket'] ?? 0
                        ]);
                    });

                    $cartProducts = CartProduct::select('id', 'product_id', 'date_service', 'hour_service', 'holder_last_name', 'holder_first_name', 'open_ticket')
                    ->where('cart_id', $cart->id)
                    ->get();
            });
        }
        catch (Throwable $e) {
            $error = $e->getMessage().$e->getFile().$e->getLine();
        }

        return collect([
            'success' => !isset($error),
            'status' => $error ?? 'success',
            'data' => isset($cartProducts) ? $this->getCartProductsResource($cartProducts, request('lang')) : false
        ]);
    }

    public function store_card_holders(Request $request)
    {
        try {
            $cartProducts = null;
            DB::transaction(function () use ($request, &$cartProducts) {
                $cart = Cart::firstOrCreate(['user_id' => auth()->user()->id]);

                collect(json_decode($request->holders))
                    ->each(function($holder) use ($cart) {
                        CartProduct::find($holder->cart_product_id)->update([
                            'holder_last_name' => isset($holder->holder_last_name) ? $holder->holder_last_name : null,
                            'holder_first_name' => isset($holder->holder_first_name) ? $holder->holder_first_name : null,
                        ]);
                    });

                    $cartProducts = CartProduct::select('id', 'product_id', 'date_service', 'hour_service', 'holder_last_name', 'holder_first_name', 'open_ticket')
                    ->where('cart_id', $cart->id)
                    ->get();
            });
        }
        catch (Throwable $e) {
            $error = $e->getMessage();
        }

        return collect([
            'success' => !isset($error),
            'status' => $error ?? 'success',
            'data' => isset($cartProducts) ? $this->getCartProductsResource($cartProducts,request('lang')) : false
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/cart_products/{cartProductId}/destroy",
     *     summary="Delete a cart product",
     *     tags={"Cart Products"},
     *     security={ {"Authentication": {} }},
     *     @OA\Parameter(
     *         name="cartProductId",
     *         in="path",
     *         required=true,
     *         description="ID of the cart product to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cart product deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="string", example="success")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="status", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cart product not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="status", type="string", example="Cart product not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to delete cart product",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="status", type="string", example="Internal Server Error")
     *         )
     *     )
     * )
     */

    public function destroy($id)
    {
        try {
            CartProduct::where('id', $id)
            ->whereHas('cart', function($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->delete();
            $cart = Cart::where('user_id', auth()->user()->id)->first();
            if ($cart->cart_products->count() == 0){
                $cart->delete();
            }
        }
        catch (Throwable $e) {
            $error = $e->getMessage();
        }

        return collect([
            'success' => !isset($error),
            'status' => $error ?? 'success'
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/cart_products/destroy-many",
     *     summary="Delete multiple cart products",
     *     tags={"Cart Products"},
     *     security={ {"Authentication": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="ids", type="array",
     *                 @OA\Items(type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cart products deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="status", type="string", example="success")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="status", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to delete cart products",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="status", type="string", example="Internal Server Error")
     *         )
     *     )
     * )
     */
    public function destroyMany(DestroyManyRequest $request)
    {
        try {
            $cart_products = CartProduct::when($request->ids, function($query) use ($request) {
                return $query->whereIn('id', json_decode($request->ids));
            })
            ->whereHas('cart', function($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->delete();

            $cart = Cart::where('user_id',auth()->user()->id)->first();

            if ($cart->cart_products->count() == 0){
                $cart->delete();
            }
        }
        catch (Throwable $e) {
            $error = $e->getMessage();
        }

        return collect([
            'success' => !isset($error),
            'status' => $error ?? 'success'
        ]);
    }


    private function getCartProductsResource($cartProducts, $lang = "it")
    {
        $cartProducts->load([
            'product' => function ($productQuery) {
                $productQuery->select('id', 'service_id', 'name', 'price_sale', 'price_web', 'is_card', 'is_name', 'check_document')
                    ->with([
                        'service' => function ($serviceQuery) {
                            $serviceQuery->select('id', 'product_category_id', 'site_id', 'max_pax', 'min_pax', 'slug')
                                ->with([
                                    'site' => function ($siteQuery) {
                                        $siteQuery->select('id', 'name', 'address', 'city', 'region', 'canonical_name', 'in_concession');
                                    }
                                ]);
                        },
                        'reductions',
                        'reduction_fields',
                        'related_products'
                    ]);
            }
        ]);

        $cartProductsData = [];
        $serviceAvailability = $this->getServiceSlotAvailability($cartProducts);
        $cartProducts->each(function ($cartProduct) use (&$cartProductsData, $serviceAvailability, $lang) {
            $cartProductsData[] = $this->getCartProductResource($cartProduct, $serviceAvailability, $lang);
        });

        return $cartProductsData;
    }
    private function getCartProductResource(CartProduct $cartProduct, $serviceAvailability, $lang = "it")
    {
        $product = $cartProduct->product;

        $dateService = $cartProduct->date_service;
        $hourService = $cartProduct->hour_service;

        $slot = ($dateService && $hourService) ? Carbon::createFromFormat('Y-m-d H:i:s', $dateService . ' ' . $hourService) : null;

        $productResource = [
            'id' => $cartProduct->id,
            'date_service' => $dateService,
            'hour_service' => $hourService,
            'holder_first_name' => $cartProduct->holder_first_name,
            'holder_last_name' => $cartProduct->holder_last_name,
            'product' => isset($product) ? $this->getProductResource($product, $slot, $serviceAvailability, $lang) : false
        ];

        return $productResource;
    }



    private function getProductResource(Product $product, Carbon $slot = null, $serviceAvailability, $lang = "it")
    {
        $service = $product->service;
        $site = $service->site;
        $productCategory = $service->product_category;
        $productName = $product->name;

        $reductions = [];
        $reductionFields = [];
        if ($product->check_document) {
            $reductions = $product->reductions->isNotEmpty() ? $product->reductions->map(function ($reduction) use ($lang) {
                return [
                    'id' => $reduction->id,
                    'name' => $reduction->name,
                ];
            }) : [];

            $reductionFields = $product->reduction_fields->isNotEmpty() ? $product->reduction_fields->map(function ($reductionField) {
                return [
                    'id' => $reductionField->id,
                    'name' => $reductionField->name,
                    'slug' => $reductionField->slug,
                ];
            }) : [];
        }

        $priceSale = $product->price_sale;
        foreach ($product->related_products as $related_prod) {
            $productName .= " + " . $related_prod->name;
            $priceSale += $related_prod->price_sale;
        }

        return [
            'id' => $product->id,
            'name' => $productName,
            'price_sale' => $priceSale,
            'category' => $productCategory ? $productCategory->name : false,
            'min_pax' => $product->getRealMinPax($slot),
            'reductions' => $reductions,
            'reduction_fields' => $reductionFields,
            'service' => $this->getServiceResource($service, $slot, $serviceAvailability),
            'site' => $this->getSiteResource($site),
            'isCard' => $product->is_card,
            'requiresName' => $product->is_name,
        ];
    }


    private function getReductionResource($reductions, $lang="it")
    {
        $reductionsArray = [];

        $reductions
            ->each(function($reduction) use (&$reductionsArray, $lang) {
                $reductionsArray[] = [
                    'id' => $reduction->id,
                    'name' => $reduction->name
                ];
            });

        return $reductionsArray;
    }


    private function getServiceResource(Service $service, Carbon $slot = null, $slotAvailability)
    {

        $siteHour = null;
        $slotAvailabilityResult = false;
        $minPax = null;
        $closingTicketOffice = null;

        if ($slot) {
            $siteHour = SiteHour::select('closing_ticket_office')
                ->where('site_id', $service->site_id)
                ->where('day', 'LIKE', '%' . strtolower($slot->format('D')) . '%')
                ->first();

            $slotAvailabilityResult = $slotAvailability[$service->id][$slot->format('Y-m-d H:i:s')] ?? false;
            $minPax = $service->getRealMinPax($slot);
            $closingTicketOffice = $siteHour->closing_ticket_office ?? null;
        }

        return [
            'id' => $service->id,
            'slot_availability' => $slotAvailabilityResult,
            'min_pax' => $minPax,
            'closing_ticket_office' => $closingTicketOffice,
            'slug' => $service->slug,
        ];
    }


    private function getSiteResource(Site $site)
    {
        return [
            'id' => $site->id,
            'name' => $site->name,
            'address' => $site->address,
            'city' => $site->city,
            'region' => $site->region,
            'canonical_name' => $site->canonical_name,
           // 'slot_availability' => $slotAvailability[$site->id][$slot->format('Y-m-d H:i:s')] ?? false,
            'in_concession' => $site->in_concession,
        ];
    }
/*
    private function getSiteSlotAvailability($cartProducts)
    {
        $siteAvailability = [];
        $cartProducts
            ->filter(function($cartProduct) {
                return isset($cartProduct->product);
            })
            ->filter(function($cartProduct) {
                return isset($cartProduct->product->service);
            })
            ->groupBy('product.service.site_id')
            ->filter(function($cartProductsBySite) {
                return isset($cartProductsBySite->first()->product->service->site);
            })
            ->filter(function($cartProductsBySite) {
                return $cartProductsBySite->first(); //->product->service->site->availability_enabled == 1;
            })
            ->each(function ($cartProductsBySite, $siteId) use(&$siteAvailability) {
                $cartProductsBySite
                    ->groupBy('date_service')
                    ->each(function ($cartProductsByDateService, $dateService) use(&$siteAvailability, $siteId) {
                        $cartProductsByDateService->groupBy('hour_service')
                            ->each(function ($cartProductsByHourService, $hourService) use(&$siteAvailability, $siteId, $dateService) {
                                $site = $cartProductsByHourService->first()->product->service->site;
                                $slot = Carbon::createFromFormat('Y-m-d H:i:s', $dateService.' '.$hourService);
                                $siteAvailability[$siteId][$dateService.' '.$hourService] = $site->getSlotAvailability($slot);
                            });
                    });
            });

        return $siteAvailability;
    }
*/

    private function getServiceSlotAvailability($cartProducts)
        {
            $serviceAvailability = [];
            $cartProducts
                ->filter(function($cartProduct) {
                    return isset($cartProduct->product);
                })
                ->filter(function($cartProduct) {
                    return isset($cartProduct->product->service);
                })
                ->groupBy('product.service_id')
                ->each(function ($cartProductsByService, $serviceId) use(&$serviceAvailability) {
                    $cartProductsByService
                        ->groupBy('date_service')
                        ->each(function ($cartProductsByDateService, $dateService) use(&$serviceAvailability, $serviceId) {
                            $cartProductsByDateService
                                ->groupBy('hour_service')
                                ->each(function ($cartProductsByHourService, $hourService) use(&$serviceAvailability, $serviceId, $dateService) {
                                    $cartProductsByHourService
                                        ->groupBy('open_ticket')
                                        ->each(function ($cartProductsByFreeSlot, $freeSlot) use(&$serviceAvailability, $serviceId, $dateService, $hourService) {
                                            if (!$freeSlot){
                                                $service = $cartProductsByFreeSlot->first()->product->service;
                                                $product = $cartProductsByFreeSlot->first()->product;
                                                $slot = Carbon::createFromFormat('Y-m-d H:i:s', $dateService.' '.$hourService);

                                                $slotService = new SlotService();
                                                $serviceAvailability[$serviceId][$dateService.' '.$hourService] = $slotService->checkAvailability('product_id', $product->id, $slot->format('Y-m-d'), $slot->format('H:i:s'), $service->site_id);
                                                if(empty($serviceAvailability)){
                                                    $serviceAvailability[$serviceId][$dateService.' '.$hourService] = $slotService->checkAvailability('service_id', $service->id, $slot->format('Y-m-d'), $slot->format('H:i:s'), $service->site_id);
                                                //$serviceAvailability[$serviceId][$dateService.' '.$hourService] = $service->getSlotAvailability($slot);
                                                }
                                            }
                                        });
                                });
                        });
                });

            return $serviceAvailability;
        }


}
