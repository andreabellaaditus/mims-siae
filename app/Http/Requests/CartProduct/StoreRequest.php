<?php

namespace App\Http\Requests\CartProduct;

use App\Services\SlotService;
use App\Models\{ CartProduct, Product, Service, Site};
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use InvalidArgumentException;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'products' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'products.required' => 'Il campo products è obbligatorio.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if($validator->valid()) {
            $validator->after(function ($validator) {

                $this->validateCart($validator);
            });
        }
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'status' => $validator->errors()
            ])
        );
    }

    private function validateCart(Validator $validator)
    {

        $cartProductsRequest = collect($this->input('products'));

        if($this->validateProductsAndSlots($validator, $cartProductsRequest))
        {
            $dbCartProducts = CartProduct::whereHas('cart', function($query) {
                    $query->where('user_id', auth()->user()->id);
                })
                ->get();

            if($this->validateProductQuantity($validator, $cartProductsRequest, $dbCartProducts))
            {
                $this->validateService($validator, $cartProductsRequest, $dbCartProducts);
                /*
                if($this->validateService($validator, $cartProductsRequest, $dbCartProducts))
                {
                    $this->validateSite($validator, $cartProductsRequest, $dbCartProducts);
                }
                */
            }
        }

        return;
    }
    private function validateProductsAndSlots(Validator $validator, $cartProducts)
    {
        $valid = true;

        $cartProducts
            ->map(function ($cartProduct) {
                return (object) $cartProduct;
            })
            ->tap(function ($cartProducts) use ($validator, &$valid) {
                $valid = $this->validateEmptyCart($validator, $cartProducts);
            })
            ->filter(function ($cartProduct) use ($validator, &$valid) {
                $validProductId = $this->validateProductId($validator, $cartProduct);
                if(!$this->validateProductId($validator, $cartProduct)) {
                    $valid = false;
                }

                return $validProductId;
            })
            ->groupBy('product_id')
            ->filter(function ($cartProductsByProduct) use ($validator, &$valid) {
                $validProductExists= $this->validateProductExists($validator, $cartProductsByProduct->first());
                if(!$validProductExists) {
                    $valid = false;
                }

                return $validProductExists;
            })
            ->each(function ($cartProductsByProduct, $productId) use ($validator, &$valid) {
                $cartProductsByProduct
                    ->groupBy('date_service')
                    ->filter(function ($cartProductsByDateService) use ($validator, &$valid) {
                        $validDateServiceExists = $this->validateDateServiceExists($validator, $cartProductsByDateService->first());
                        if(!$validDateServiceExists) {
                            $valid = false;
                        }

                        return $validDateServiceExists;
                    })
                    ->filter(function ($cartProductsByDateService) use ($validator, &$valid) {
                        $validDateServiceFormat = $this->validateDateServiceFormat($validator, $cartProductsByDateService->first());
                        if(!$validDateServiceFormat) {
                            $valid = false;
                        }

                        return $validDateServiceFormat;
                    })
                    ->filter(function ($cartProductsByDateService) use ($validator, &$valid) {
                        $validDateService = $this->validateDateServiceOld($validator, $cartProductsByDateService->first());
                        if(!$validDateService) {
                            $valid = false;
                        }

                        return $validDateService;
                    })
                    ->each(function ($cartProductsByDateService, $dateService) use ($validator, &$valid, $productId) {
                        $product = Product::find($productId);
                        $cartProductsByDateService
                            ->groupBy('hour_service')
                            ->filter(function ($cartProductsByHourService) use ($validator, &$valid) {
                                $validHourServiceExists = $this->validateHourServiceExists($validator, $cartProductsByHourService->first());
                                if(!$validHourServiceExists) {
                                    $valid = false;
                                }

                                return $validHourServiceExists;
                            })
                            ->filter(function ($cartProductsByHourService) use ($validator, &$valid) {
                                $validHourServiceFormat = $this->validateHourServiceFormat($validator, $cartProductsByHourService->first());
                                if(!$validHourServiceFormat) {
                                    $valid = false;
                                }

                                return $validHourServiceFormat;
                            })
                            ->filter(function ($cartProductsByHourService) use ($validator, &$valid) {
                                $validHourService = $this->validateHourServiceOld($validator, $cartProductsByHourService->first());
                                if(!$validHourService) {
                                    $valid = false;
                                }

                                return $validHourService;
                            })
                            ->each(function($cartProductsByHourService) use ($validator, &$valid, $product) {
                                $cartProduct = $cartProductsByHourService->first();
                                $freeSlot = $cartProduct->open_ticket ?? 0;
                                if ($freeSlot){
                                    return true;
                                }
                                $slot = Carbon::createFromFormat('Y-m-d H:i', $cartProduct->date_service.' '.$cartProduct->hour_service);

                                if (!$this->validateProductClosingReservation($validator, $product, $slot)) {
                                    $valid = false;
                                }
                                if (!$this->validateProductMinPax($validator, $product, $slot, $cartProductsByHourService)) {
                                    $valid = false;
                                }
                            });
                    });
            });

        return $valid;
    }





    private function validateEmptyCart(Validator $validator, $cartProducts)
    {
        $emptyCart = $cartProducts->isEmpty();
        if($emptyCart) {
            $validator->errors()->add('products', 'empty_cart');
        }

        return !$emptyCart;
    }

    private function validateProductId(Validator $validator, $cartProduct)
    {
        $validProductId = isset($cartProduct->product_id) && !empty($cartProduct->product_id);
        if(!$validProductId) {
            $validator->errors()->add('product_id', 'required');
        }

        return $validProductId;
    }

    private function validateProductExists(Validator $validator, $cartProduct)
    {
        $productExists = Product::where('id', $cartProduct->product_id)->exists();
        if (!$productExists) {
            $validator->errors()->add('product_id: '.$cartProduct->product_id, 'not_found');
        }

        return $productExists;
    }

    private function validateDateServiceExists(Validator $validator, $cartProduct)
    {
        $freeSlotExists = $cartProduct->open_ticket ?? 0;
        $dateServiceExists = $freeSlotExists ? 1 : isset($cartProduct->date_service) && !empty($cartProduct->date_service );
        if(!$dateServiceExists) {
            $validator->errors()->add('date_service', 'required');
        }

        return $dateServiceExists;
    }

    private function validateDateServiceFormat(Validator $validator, $cartProduct)
    {
        try {
            $freeSlotExists = $cartProduct->open_ticket ?? 0;
            if ($freeSlotExists){
                return true;
            }
            Carbon::createFromFormat('Y-m-d', $cartProduct->date_service);
            return true;
        }
        catch (InvalidArgumentException $e) {
            $validator->errors()->add('date_service', 'format: Y-m-d');
            return false;
        }
    }

    private function validateDateServiceOld(Validator $validator, $cartProduct)
    {
        $freeSlotExists = $cartProduct->open_ticket ?? 0;
        if ($freeSlotExists){
            return true;
        }
        $serviceDate = Carbon::createFromFormat('Y-m-d', $cartProduct->date_service)->startOfDay();
        $todayDate = Carbon::now()->startOfDay();

        if ($todayDate->gt($serviceDate)) {
            $validator->errors()->add('date_service', 'old_date');
        }

        return $todayDate->lte($serviceDate);
    }

    private function validateHourServiceExists(Validator $validator, $cartProduct)
    {
        $freeSlotExists = $cartProduct->open_ticket ?? 0;
        $hourServiceExists = $freeSlotExists ? 1 : isset($cartProduct->hour_service) && !empty($cartProduct->hour_service );
        if(!$hourServiceExists) {
            $validator->errors()->add('hour_service', 'required');
        }

        return $hourServiceExists;
    }

    private function validateHourServiceFormat(Validator $validator, $cartProduct)
    {
        try {
            $freeSlotExists = $cartProduct->open_ticket ?? 0;
            if ($freeSlotExists){
                return true;
            }
            Carbon::createFromFormat('H:i', $cartProduct->hour_service);
            return true;
        }
        catch (InvalidArgumentException $e) {
            $validator->errors()->add('hour_service', 'format: H:i');
            return false;
        }
    }

    private function validateHourServiceOld(Validator $validator, $cartProduct)
    {
        $freeSlotExists = $cartProduct->open_ticket ?? 0;
        if ($freeSlotExists){
            return true;
        }
        $slot = Carbon::createFromFormat('Y-m-d H:i:s', $cartProduct->date_service.' '.$cartProduct->hour_service.":00");
        $now = Carbon::now();

        if ($now->gt($slot)) {
            $validator->errors()->add('hour_service', 'old_hour');
        }

        return $now->lt($slot);
    }


    private function validateProductClosingReservation(Validator $validator, Product $product, Carbon $slot)
    {
        $closingReservation = isset($product->service->site->closing_ticket_office) ? $slot->copy()->subHours($product->service->site->closing_ticket_office) : null;
        $now = Carbon::now();

        $invalidClosingReservation = isset($closingReservation) && $now->gt($closingReservation);
        if ($invalidClosingReservation) {
            $validator->errors()->add(
                'product_id: '.$product->id.' | service_date: '.$slot->format('Y-m-d').' | hour_service: '.$slot->format('H:i'),
                'product_reservation_closed'
            );
        }

        return !$invalidClosingReservation;
    }

    private function validateProductMinPax(Validator $validator, Product $product, Carbon $slot, $cartProductsByHourService)
    {
        $realMinPax = $product->getRealMinPax($slot);
        $invalidMinPax = $realMinPax > $cartProductsByHourService->count();
        if ($invalidMinPax) {
            $cartProduct = $cartProductsByHourService->first();
            $validator->errors()->add(
                'product_id: '.$cartProduct->product_id.' | service_date: '.$cartProduct->date_service.' | hour_service: '.$cartProduct->hour_service,
                'product_min_pax_'.$realMinPax
            );
        }

        return !$invalidMinPax;
    }

    private function validateProductQuantity(Validator $validator, $cartProductsRequest, $dbCartProducts)
    {
        $valid = true;
        $cartProductsRequest
            ->groupBy('product_id')
            ->each(function ($cartProductsByProduct, $productId) use ($validator, $dbCartProducts, &$valid) {
                $requestQty = $cartProductsByProduct->count();
                $dbQty = $dbCartProducts
                    ->where('product_id', $productId)
                    ->count();
                    $max_purchasable_qty = env('DEFAULT_MAXIMUM_PURCHASABLE_QUANTITY');

                    if (($requestQty + $dbQty) > $max_purchasable_qty) {
                        $valid = false;
                        $validator->errors()->add('product_id: '.$productId, 'max_'.$max_purchasable_qty);
                    }
            });

        return $valid;
    }


private function validateService(Validator $validator, $cartProductsRequest, $dbCartProducts)
{
    $valid = true;

    //$cartProductsRequest = collect($cartProductsRequest);

    $cartProductsRequest
        ->groupBy('product_id')
        ->each(function ($cartProductsByProduct, $productId) use ($validator, $dbCartProducts, &$valid) {
            $cartProductsByProduct
                ->groupBy('date_service')
                ->each(function ($cartProductsByDateService, $dateService) use ($validator, $dbCartProducts, &$valid) {
                    $cartProductsByDateService
                        ->groupBy('hour_service')
                        ->each(function ($cartProductsByHourService, $hourService) use ($validator, $dbCartProducts, &$valid) {
                            $cartProduct = $cartProductsByHourService->first();

                            $service = Service::select('id', 'max_pax', 'min_pax', 'site_id', 'is_date', 'is_hour')
                                ->whereHas('products', function($query) use ($cartProduct) {
                                    $query->where('id', $cartProduct['product_id']);
                                })
                                ->first();

                            if(isset($service) && isset($cartProduct['date_service']) && isset($cartProduct['hour_service']))
                            {
                                $slot = Carbon::createFromFormat('Y-m-d H:i', $cartProduct['date_service'].' '.$hourService);

                                $dbQty = $dbCartProducts->where('product_id', $cartProduct['product_id'])
                                    ->where('date_service', $cartProduct['date_service'])
                                    ->where('hour_service', $hourService.':00')
                                    ->count();
                                $requestQty = $cartProductsByHourService->count();
                                $qty = $requestQty + $dbQty;
                                $product = Product::find($cartProduct['product_id']);

                                if($service->is_date || $service->is_hour || $product->is_date || $product->is_hour ){
                                    if(!$this->validateServiceAvailability($validator, $service, $slot, $cartProduct['product_id'], $qty)) {
                                        $valid = false;
                                    }
                                }
                                if(!$this->validateServiceClosingReservation($validator, $service, $slot, $cartProduct['product_id'])) {
                                    $valid = false;
                                }
                                if(!$this->validateServiceMinPax($validator, $service, $slot, $cartProductsByHourService)) {
                                    $valid = false;
                                }
                            }
                        });
                });
        });

    return $valid;
}


    private function validateServiceAvailability(Validator $validator, Service $service, Carbon $slot, $productId, $qty)
    {
        $slotService = new SlotService();
        $availability = $slotService->checkAvailability('product_id', $productId, $slot->format('Y-m-d'), $slot->format('H:i:s'), $service->site_id);
        if(empty($availability)){
            $availability = $slotService->checkAvailability('service_id', $service->id, $slot->format('Y-m-d'), $slot->format('H:i:s'), $service->site_id);
        }
        $validServiceAvailability = $availability >= $qty;

        if (!$validServiceAvailability) {
            $validator->errors()->add(
                'product_id: '.$productId.' | service_date: '.$slot->format('Y-m-d').' | hour_service: '.$slot->format('H:i'),
                'product_service_not_available');
        }

        return $validServiceAvailability;
    }

    private function validateServiceClosingReservation(Validator $validator, Service $service, Carbon $slot, $productId)
    {
        $closingReservation = isset($slot, $service->site->closing_ticket_office) ? $slot->copy()->subHours($service->site->closing_ticket_office) : null;
        $now = Carbon::now();

        $invalidClosingReservation = isset($closingReservation) && $now->gt($closingReservation);
        if ($invalidClosingReservation) {
            $validator->errors()->add(
                'product_id: '.$productId.' | service_date: '.$slot->format('Y-m-d').' | hour_service: '.$slot->format('H:i'),
                'product_service_reservation_closed'
            );
        }

        return !$invalidClosingReservation;
    }

    private function validateServiceMinPax(Validator $validator, Service $service, Carbon $slot, $cartProductsByHourService)
    {
        $realMinPax = $service->getRealMinPax($slot);
        $invalidMinPax = $realMinPax > $cartProductsByHourService->count();
        if ($invalidMinPax) {
            $cartProduct = $cartProductsByHourService->first();
            $validator->errors()->add(
                'product_id: '.$cartProduct->product_id.' | service_date: '.$cartProduct->date_service.' | hour_service: '.$cartProduct->hour_service,
                'product_service_min_pax_'.$realMinPax
            );
        }

        return !$invalidMinPax;
    }

/*
    private function validateSite(Validator $validator, $cartProductsRequest, $dbCartProducts)
    {
        $cartProductsRequest
            ->groupBy('product_id')
            ->each(function ($cartProductsByProduct, $productId) use ($validator, $dbCartProducts) {
                $cartProductsByProduct
                    ->groupBy('date_service')
                    ->each(function ($cartProductsByDateService, $dateService) use ($validator, $dbCartProducts) {
                        $cartProductsByDateService
                            ->groupBy('hour_service')
                            ->each(function ($cartProductsByHourService, $hourService) use ($validator, $dbCartProducts) {
                                $cartProduct = $cartProductsByHourService->first();
                                $slot = Carbon::createFromFormat('Y-m-d H:i', $cartProduct->date_service.' '.$hourService);

                                $dbQty = $dbCartProducts->where('product_id', $cartProduct->product_id)
                                    ->where('date_service', $cartProduct->date_service)
                                    ->where('hour_service', $hourService.':00')
                                    ->count();
                                $requestQty = $cartProductsByHourService->count();
                                $qty = $requestQty + $dbQty;

                                $this->validateSiteAvailability($validator, $slot, $cartProduct->product_id, $qty);
                            });
                    });
            });

        return;
    }
    private function validateSiteAvailability(Validator $validator, Carbon $slot, $productId, $qty)
    {
        $product = Product::with(['product_category'])->find($productId);
        $site = Site::select('id', 'availability_enabled', 'availability_pax')
            ->whereHas('product_services.products', function($query) use ($productId) {
                $query->where('id', $productId);
            })
            ->first();

        if(isset($site) && $product->service->product_category->name == 'ticket')
        {
            $siteAvailability = $site->getSlotAvailability($slot);
            if ($siteAvailability < $qty)
            {
                $validator->errors()->add(
                    'product_id: '.$productId.' | service_date: '.$slot->format('Y-m-d').' | hour_service: '.$slot->format('H:i'),
                    'product_site_not_available'
                );
            }
        }

        return;
    }

*/
}
