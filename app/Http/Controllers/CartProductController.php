<?php

namespace App\Http\Controllers;

use App\Services\SlotService;
use App\Models\{ User, Cart, CartProduct, Product, Service, Site, SiteHour};
use App\Http\Controllers\Controller;
use App\Http\Requests\CartProduct\{ DestroyManyRequest, StoreRequest };
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



class CartProductController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('logged-user')->except('index', 'store', 'destroyMany');
    }*/

    public function index(Request $request)
    {
        $cartProductsData = [];
        try {
            $user = User::where('email', $request->email)->first();
            if ($user) {

                $cartProducts = CartProduct::select('id', 'cart_id', 'product_id', 'date_service', 'hour_service', 'holder_last_name', 'holder_first_name', 'open_ticket')
                    ->whereHas('cart', function($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })
                    ->get();

                if ($cartProducts->isNotEmpty()) {
                    $cartProductsData = $this->getCartProductsResource($cartProducts, $request->input('lang', 'it'));
                }
            } else {
                $error = "User not found with the given email.";
            }

        } catch (Throwable $e) {
            $error = $e->getMessage();
        }

        return response()->json([
            'success' => !isset($error),
            'status' => $error ?? 'success',
            'data' => $cartProductsData
        ]);
    }



    /*$apiUrl = env('MIMS_API_URL') . '/v3/cart_products/index';
    $response = Http::get($apiUrl);

    if ($response->successful()) {
        return $response->json();
    } else {
        $error = $response->body();
    }*/
     public function store(StoreRequest $request)
     {
        $cartProducts = null;
        $error = null;
        $user = User::where('email', $request->email)->first();

        try {

            DB::transaction(function () use ($request, &$cartProducts, $user) {
                $cart = Cart::firstOrCreate(['user_id' => $user->id]);
                $products = is_string($request->products) ? json_decode($request->products, true) : $request->products;
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

        } catch (Throwable $e) {
            $error = $e->getMessage() . $e->getFile() . $e->getLine();
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
    public function destroyMany(DestroyManyRequest $request)
    {

        try {

            $cart_products = CartProduct::when($request->ids, function ($query) use ($request) {
                $ids = array_column($request->ids, 'id');
                return $query->whereIn('id', $ids);
            })
            ->get();

            $deletedCount = $cart_products->count();

            if ($deletedCount > 0) {
                CartProduct::destroy($cart_products->pluck('id'));
            }

            $cartId = $deletedCount > 0 ? $cart_products->first()->cart_id : null;

            if ($cartId) {
                $cart = Cart::find($cartId);

                if ($cart && $cart->cart_products->count() == 0) {
                    $cart->delete();
                }
            }
        } catch (Throwable $e) {
            Log::error('Errore nella funzione destroyMany:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
        }

        return collect([
            'success' => true,
            'status' => 'success'
        ]);
    }


    private function getCartProductsResource($cartProducts, $lang = "it")
    {
        $cartProducts->load([
            'product' => function ($productQuery) {
                $productQuery->select('id', 'service_id', 'name', 'price_sale', 'price_web', 'is_card', 'is_name', 'check_document', 'is_siae')
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
            'is_siae' => $product->is_siae,
            'date_service' => $dateService,
            'hour_service' => $hourService,
            'free_slot' => $cartProduct->open_ticket,
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
                                            if (!$freeSlot) {
                                                $service = $cartProductsByFreeSlot->first()->product->service;
                                                $product = $cartProductsByFreeSlot->first()->product;

                                                // Verifica se $dateService e $hourService sono null o vuoti, in tal caso usa la data e ora attuali
                                                $dateService = !empty($dateService) ? $dateService : Carbon::now()->format('Y-m-d');
                                                $hourService = !empty($hourService) ? $hourService : Carbon::now()->format('H:i:s');

                                                $slot = Carbon::createFromFormat('Y-m-d H:i:s', $dateService.' '.$hourService);

                                                $slotService = new SlotService();
                                                $serviceAvailability[$serviceId][$dateService.' '.$hourService] = $slotService->checkAvailability('product_id', $product->id, $slot->format('Y-m-d'), $slot->format('H:i:s'), $service->site_id);

                                                // Controllo di fallback per la disponibilità del servizio
                                                if (empty($serviceAvailability)) {
                                                    $serviceAvailability[$serviceId][$dateService.' '.$hourService] = $slotService->checkAvailability('service_id', $service->id, $slot->format('Y-m-d'), $slot->format('H:i:s'), $service->site_id);
                                                    // $serviceAvailability[$serviceId][$dateService.' '.$hourService] = $service->getSlotAvailability($slot);
                                                }
                                            }

                                        });
                                });
                        });
                });

            return $serviceAvailability;
        }


}
