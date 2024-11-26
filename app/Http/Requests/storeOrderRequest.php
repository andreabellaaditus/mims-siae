<?php

namespace App\Http\Requests;

use App\Services\SlotService;
use App\Models\{Cart, CartProduct, DocumentType, Product, ProductReductionField, ReductionField, Reduction, Service, User };
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use InvalidArgumentException;
use Illuminate\Support\Facades\Log;

class storeOrderRequest extends FormRequest
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

            'terms_and_conditions' => 'accepted',
            //'payment_method_id' => 'required|string',
            'payment_intent' => 'nullable|string',
            'invoice' => 'required|boolean',
            //'reductions' => 'array',
            'lang' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'terms_and_conditions.accepted' => 'must_be_accepted',
            //'payment_method_id.required' => 'required',
            //'payment_method_id.string' => 'string',
            //'payment_intent.required' => 'required',
            'payment_intent.string' => 'string',
            'invoice.required' => 'required',
            'invoice.boolean' => 'boolean',
            //'reductions.json' => 'invalid_json'
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
                try {
                    $this->validateCart($validator);
                }
                catch(InvalidArgumentException $e) {
                    $error = $e->getMessage();
                }
            });
        }
    }

    public function failedValidation(Validator $validator)
    {
        log::info($validator->errors());
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'status' => $validator->errors()
            ])
        );
    }
    private function validateCart(Validator $validator)
    {
        $user = request()->input('user');
        $user = User::where('email', $user['email'])->first();
        auth()->setUser($user);

        $cart = Cart::with([
                'cart_products' => function($cartProducts) {
                    $cartProducts->with([
                        'product' => function($product) {
                            $product->select('id', 'service_id', 'price_sale')
                                ->with([
                                    'service' => function($service) {
                                        $service->select('id', 'site_id', 'product_category_id', 'max_pax', 'min_pax', 'is_pending')
                                            ->with([
                                                'site' => function($site) {
                                                    $site->select('id');
                                                },

                                                'product_category' => function($productCategory) {
                                                    $productCategory->select('id', 'name');
                                                }
                                            ]);
                                    },
                                ]);
                        }
                    ]);
                }
            ])
            ->where('user_id', auth()->user()->id)
            ->first();

        //if($this->validateCartValidator($validator, $cart))
        //{
           /* Log::info(__LINE__);
            //$this->validatePaymentMethod($validator, $cart);
            if($this->validateProductsAndSlots($validator, $cart->cart_products))
            {
                Log::info(__LINE__);
                if($this->validateReductionsStructure($validator))
                {
                    Log::info(__LINE__);
                    $this->validateReductions($validator, $cart->cart_products);
                }

                if($this->validateService($validator, $cart->cart_products))
                {
                    Log::info(__LINE__);
                    //$this->validateSite($validator, $cart->cart_products);
                }
            }*/
        //}

        return;
    }
    private function validateCartValidator($validator, Cart $cart = null)
    {
        if(!isset($cart)) {
            $validator->errors()->add('cart', 'empty');
        }

        return isset($cart);
    }

    /*private function validatePaymentMethod(Validator $validator, Cart $cart)
    {
        if($cart->getConfirmedTotal($cart) > 0 && is_null($this->request->get('payment_method_id'))) {
            $validator->errors()->add('payment_method_id', 'required');
        }

        return;
    }*/

    private function validateProductsAndSlots(Validator $validator, $cartProducts)
    {
        $valid = true;

        $cartProducts
            ->tap(function ($cartProducts) use ($validator, &$valid) {
                $valid = $this->validateEmptyCart($validator, $cartProducts);
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
                        $validDateService = $this->validateDateServiceOld($validator, $cartProductsByDateService->first());
                        if(!$validDateService) {
                            $valid = false;
                        }

                        return $validDateService;
                    })
                    ->each(function ($cartProductsByDateService, $dateService) use ($validator, &$valid) {
                        $cartProductsByDateService
                            ->groupBy('hour_service')
                            ->filter(function ($cartProductsByHourService) use ($validator, &$valid) {
                                $validHourService = $this->validateHourServiceOld($validator, $cartProductsByHourService->first());
                                if(!$validHourService) {
                                    $valid = false;
                                }

                                return $validHourService;
                            })
                            ->each(function($cartProductsByHourService) use ($validator, &$valid) {
                                $cartProduct = $cartProductsByHourService->first();
                                $product = $cartProduct->product;
                                $slot = Carbon::createFromFormat('Y-m-d H:i:s', $cartProduct->date_service.' '.$cartProduct->hour_service);

                                if(!$this->validateProductClosingReservation($validator, $product, $slot)) {
                                    $valid = false;
                                }
                                if(!$this->validateProductMinPax($validator, $product, $slot, $cartProductsByHourService->count())) {
                                    $valid = false;
                                }
                            });
                    });
            });

        return $valid;
    }

    private function validateReductionsStructure(Validator $validator)
    {
        $valid = true;
        if(!is_null($this->input('reductions')))
        {
            collect($this->input('reductions'))
                ->groupBy('product_id')
                ->each(function($requestReductions, $productId) use ($validator, &$valid) {
                    $requiredFields = ProductReductionField::where('product_id', $productId)
                        ->pluck('reduction_field_id');

                    $requestReductions->each(function($requestReduction) use ($validator, $requiredFields, &$valid) {
                        $fieldsValid = $this->validateReductionFields($validator, $requiredFields, $requestReduction);
                        if (!$fieldsValid) {
                            $valid = false;
                        }
                    });
                });
        }

        return $valid;
    }

    private function validateReductionFields(Validator $validator, $requiredFields, $reduction)
    {
        $valid = true;
        $requiredFields->each(function($fieldId) use ($validator, $reduction, &$valid) {
            if($reduction['reduction_field_id'] == $fieldId){
                $fieldValue = $reduction['value'];
                if (is_null($fieldValue) || empty($fieldValue)) {
                    $fieldName = ReductionField::find($fieldId)->name;
                    $validator->errors()->add('reductions.' . $fieldName, 'required');
                    $valid = false;
                }
            }
        });

        return $valid;
    }

    private function validateReductions(Validator $validator, $cartProducts)
    {
        $cartProducts
            ->groupBy('product_id')
            ->each(function ($cartProductsByProduct) use ($validator) {
                $this->validateReductionsQty($validator, $cartProductsByProduct);
            });

        return;
    }

    private function validateReductionsQty(Validator $validator, $cartProductsByProduct)
    {
        $cartProduct = $cartProductsByProduct->first();
        $prodQty = 0;
        $inputQty = 0;

        $reductionsInput = $this->input('reductions');
        foreach($cartProductsByProduct as $cartProduct){
            $prodQty++;
        }

        if(isset($reductionsInput)){
            foreach($reductionsInput as $input){
                if($input['product_id'] == $cartProduct->product_id){
                    $inputQty++;
                }
            }
        }
        $requestedReductionFieldsQty = $prodQty * $cartProduct->product->reduction_fields->count();
        if ($inputQty < $requestedReductionFieldsQty && $cartProduct->product->check_document == 1) {
            $validator->errors()->add('reductions', 'Reduction documents are required for product_id: ' . $cartProduct->product_id);
        }

        return;
    }


    private function validateEmptyCart(Validator $validator, $cartProducts)
    {
        $emptyCart = $cartProducts->isEmpty();
        if($emptyCart) {
            $validator->errors()->add('cart', 'empty');
        }

        return !$emptyCart;
    }

    private function validateProductExists(Validator $validator, $cartProduct)
    {
        $product = $cartProduct->product;
        if (!isset($product)) {
            $validator->errors()->add('cart.product_id', 'product_id: '.$cartProduct->product_id.' not found');
        }

        return isset($product);
    }

    private function validateDateServiceOld(Validator $validator, $cartProduct)
    {
        $serviceDate = Carbon::createFromFormat('Y-m-d', $cartProduct->date_service)->startOfDay();
        $todayDate = Carbon::now()->startOfDay();

        if ($todayDate->gt($serviceDate)) {
            $validator->errors()->add('cart.date_service', 'Old date: '.$cartProduct->date_service);
        }

        return $todayDate->lte($serviceDate);
    }

    private function validateHourServiceOld(Validator $validator, $cartProduct)
    {
        $serviceDatetime = Carbon::createFromFormat('Y-m-d H:i:s', $cartProduct->date_service.' '.$cartProduct->hour_service);
        $todayDatetime = Carbon::now();

        if ($todayDatetime->gt($serviceDatetime)) {
            $validator->errors()->add('cart.hour_service', 'Old hour: '.$cartProduct->hour_service);
        }

        return $todayDatetime->lt($serviceDatetime);
    }


    private function validateService(Validator $validator, $cartProducts)
    {
        $valid = true;

        $cartProducts
            ->groupBy('product_id')
            ->filter(function ($cartProductsByProduct) {
                return isset($cartProductsByProduct->first()->product->service);
            })
            ->each(function ($cartProductsByProduct, $productId) use ($validator, &$valid) {
                $cartProductsByProduct
                    ->groupBy('date_service')
                    ->each(function ($cartProductsByDateService, $dateService) use ($validator, &$valid) {
                        $cartProductsByDateService
                            ->groupBy('hour_service')
                            ->each(function ($cartProductsByHourService, $hourService) use ($validator, &$valid) {
                                $cartProduct = $cartProductsByHourService->first();
                                $qty = $cartProductsByHourService->count();
                                $service = $cartProduct->product->service;
                                $slot = Carbon::createFromFormat('Y-m-d H:i:s', $cartProduct->date_service.' '.$cartProduct->hour_service);

                                if(!$this->validateServiceAvailability($validator, $service, $slot, $cartProduct->product_id, $qty)) {
                                    $valid = false;
                                }
                                if(!$this->validateServiceClosingReservation($validator, $service, $slot, $cartProduct->product_id)) {
                                    $valid = false;
                                }
                                if(!$this->validateServiceMinPax($validator, $service, $slot, $cartProductsByHourService)) {
                                    $valid = false;
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

        //$validServiceAvailability = $service->getSlotAvailability($slot) >= $qty;
        if (!$validServiceAvailability)
        {
            $validator->errors()->add(
                'cart.product.service',
                'Service without slot availability for product_id: '.$productId.' | date: '.$slot->format('Y-m-d').' | hour: '.$slot->format('H:i')
            );
        }

        return $validServiceAvailability;
    }

    private function validateProductClosingReservation(Validator $validator, Product $product, Carbon $slot)
    {
        $closingReservation = isset($product->service->site->closing_ticket_office) ? $slot->copy()->subHours($product->service->site->closing_ticket_office) : null;

        $invalidClosingReservation = isset($closingReservation) && Carbon::now()->gt($closingReservation);
        if ($invalidClosingReservation) {
            $validator->errors()->add(
                'cart.product',
                'Product reservation closed for product_id: '.$product->id.' | date: '.$slot->format('Y-m-d').' | hour: '.$slot->format('H:i')
            );
        }

        return !$invalidClosingReservation;
    }

    private function validateProductMinPax(Validator $validator, Product $product, Carbon $slot, $qty)
    {
        $realMinPax = $product->getRealMinPax($slot);
        $invalidMinPax = $realMinPax > $qty;
        if ($invalidMinPax) {
            $validator->errors()->add(
                'cart.product',
                'The minimum quantity to buy is '.$realMinPax.' for product_id: '.$product->id.' | date: '.$slot->format('Y-m-d').' | hour: '.$slot->format('H:i')
            );
        }

        return !$invalidMinPax;
    }

    private function validateServiceClosingReservation(Validator $validator, Service $service, Carbon $slot, $productId)
    {
        $closingReservation = isset($slot, $service->site->closing_ticket_office) ? $slot->copy()->subHours($service->site->closing_ticket_office) : null;

        $invalidClosingReservation = isset($closingReservation) && Carbon::now()->gt($closingReservation);
        if ($invalidClosingReservation) {
            $validator->errors()->add(
                'cart.product.service',
                'Service reservation closed for product_id: '.$productId.' | date: '.$slot->format('Y-m-d').' | hour: '.$slot->format('H:i')
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
                'cart.product.service',
                'The minimum quantity to buy is '.$realMinPax.' for product_id: '.$cartProduct->product_id.' | date: '.$slot->format('Y-m-d').' | hour: '.$slot->format('H:i')
            );
        }

        return !$invalidMinPax;
    }
}
/*
    private function validateSite(Validator $validator, $cartProducts)
    {
        $cartProducts
            ->groupBy('product_id')
            ->filter(function ($cartProductsByProduct) {
                return isset($cartProductsByProduct->first()->product->service);
            })
            ->filter(function ($cartProductsByProduct) {
                return isset($cartProductsByProduct->first()->product->service->site);
            })
            ->filter(function ($cartProductsByProduct) {
                return $cartProductsByProduct->first()->product->service->site->availability_enabled == 1;
            })
            ->each(function ($cartProductsByProduct, $productId) use ($validator) {
                $cartProductsByProduct
                    ->groupBy('date_service')
                    ->each(function ($cartProductsByDateService, $dateService) use ($validator) {
                        $cartProductsByDateService
                            ->groupBy('hour_service')
                            ->each(function ($cartProductsByHourService, $hourService) use ($validator) {
                                $cartProduct = $cartProductsByHourService->first();
                                $qty = $cartProductsByHourService->count();

                                $this->validateSiteAvailability($validator, $cartProduct, $qty);
                            });
                    });
            });

        return;
    }
    private function validateSiteAvailability(Validator $validator, CartProduct $cartProduct, $qty)
    {
        $slot = Carbon::createFromFormat('Y-m-d H:i:s', $cartProduct->date_service.' '.$cartProduct->hour_service);
        $site = $cartProduct->product->service->site;
        if ($site->getSlotAvailability($slot) < $qty)
        {
            $validator->errors()->add(
                'cart.product.site',
                'Site without slot availability for product_id '.$cartProduct->product_id.' | date: '.$slot->format('Y-m-d').' | hour: '.$slot->format('H:i')
            );
        }

        return;
    }

*/
