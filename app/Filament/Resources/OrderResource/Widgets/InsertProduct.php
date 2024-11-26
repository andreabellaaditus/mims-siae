<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Filament\Resources\OrderResource;
use Filament\Widgets\Widget;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Service;
use App\Models\Order;
use App\Models\Cart;
use App\Models\MatrixChoice;
use App\Models\CartProduct;
use App\Services\ProductsService;
use App\Services\CartService;
use App\Services\CartProductService;
use App\Services\ServiceService;
use App\Services\ProductCategoryService;
use App\Services\ProductService;
use App\Services\OrderService;
use App\Services\CashierService;
use App\Services\SiaeService;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Set;
use Carbon\Carbon;

class InsertProduct extends Widget implements HasForms
{
    protected static string $view = 'filament.resources.order-resource.widgets.insert-product';
    public $categories;
    public int $site_id;

    use InteractsWithForms;
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Tabs::make('Tabs')
            ->tabs(self::getProdCatTabs($this->site_id)),
        ]);
    }

    public static function getProdCatTabs($site_id){

        $prodCatService = new ProductCategoryService;
        $product_categories = $prodCatService->getBySite($site_id);

        $tabs = array();
        foreach($product_categories as $product_category){
            $services = self::getServices($product_category->id, $site_id);
            if(!empty($services[0]->getOptions())){
                $tabs[] = Forms\Components\Tabs\Tab::make(__($product_category->slug.'.plural-model-label'))
                ->schema(
                    $services
                );
            }
        }
        return $tabs;
    }

    public static function getServices($product_category_id, $site_id) : array{
        $serviceService = new ServiceService;
        $res = $serviceService->getByProductCategoryAndSite($product_category_id, $site_id);
        $services = array();
        $products = array();
        $product_category = '';
        foreach($res as $row){
            $product_category = $row->product_category->slug;
            $products[$row['name']] = self::getProducts($row['id']);
            if(empty($products[$row['name']])){
                unset($products[$row['name']]); }
        }
        if($product_category != ''){
            $services[] =
        Select::make('categories.'.$product_category)
            ->label(__('orders.form.select-products'))
            ->searchable()
            ->options($products)
            ->live()
            ->disableOptionWhen(function(string $value){
                $product = new Product();
                $product->id = $value;
                $productService = new ProductService($product);
                $res_del = $productService->getIsDeliverable();

                $orderService = new OrderService;
                $cashierService = new CashierService;
                $site_id = request('site_id') ? request('site_id') : session('site_id');
                $currentUser = $orderService->getCurrentUser($site_id);

                return !$res_del->deliverable || $cashierService->hasAnotherSiteOpen($currentUser->id, $site_id);
            })
            ->extraAttributes(['class' => 'choose-products'])
            ->afterStateUpdated(function (Set $set, $state) {
                $cartService = new CartService();
                $cartProductService = new CartProductService();
                $currentUser = auth()->user();
                if(!$cartService->checkExisting($currentUser->id)){
                    $cart_data = [
                    'user_id' => $currentUser->id
                    ];
                    $cartService->create($cart_data);

                }else{
                    $conditions = ['user_id' => auth()->user()->id];
                    $cart_data = [
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                    $cartService->update($conditions, $cart_data);
                }
                $current_cart = $cartService->getCart($currentUser->id);

                $conditions = ['cart_id' => $current_cart->id, 'product_id' => $state];
                $existing_prod = $cartProductService->searchIdenticalProducts($conditions);
                $date_service = null;
                $hour_service = null;
                if($existing_prod){
                    $date_service = $existing_prod->date_service;
                    $hour_service = $existing_prod->hour_service;
                }

                $data_cart_product = [
                    'cart_id' => $current_cart->id,
                    'product_id' => $state,
                    'date_service' => $date_service,
                    'hour_service' => $hour_service,
                ];
                $cartProductService->create($data_cart_product);

                $product = Product::find($state);
                $set('categories.'.$product->service->product_category->slug, 0);
            });
        }

        return $services;
    }

    public static function getProducts($service_id) : array{
        $productService = new ProductsService();
        $type= 'onsite';
        $products = $productService->getSalable($service_id, $type);
        $arr_prod = array();
        foreach($products as $product){
            $related_products = Product::join('related_products', 'related_products.product_id', 'products.id')->where('related_products.main_product_id', $product['id'])->get();
            foreach($related_products as $related_prod){
                $product['name'].= " + ".$related_prod['name'];
                $product['price_sale'] += $related_prod['price_sale'];
            }
            if($product['date_event'] != null){
                $product['name'].= " (". date('d-m-Y H:i', strtotime($product['date_event'])).")";
            }

            /*if($product['is_siae'] == 1){
                $siaeService = new SiaeService();
                $product['name'].= $siaeService->getEditedProductName($product['code'], $product['cod_ordine_posto']);
            }*/
            $arr_prod[$product['id']] = $product['name']." (".number_format($product['price_sale'], 2, ",")." €)";
        }
        return $arr_prod;
    }


    public function updated()
    {
        $this->dispatch('refresh_cart');
        $this->dispatch('refresh_dates');
    }

}
