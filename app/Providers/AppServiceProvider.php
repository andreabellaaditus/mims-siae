<?php

namespace App\Providers;

use App\Filament\Resources\ServiceResource;
use App\Filament\Resources\OrderResource;
use Filament\Facades\Filament;
use App\Models\ProductCategory;
use App\Models\Site;
use App\Models\OrderType;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use BezhanSalleh\FilamentLanguageSwitch\Enums\Placement;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\Blade;
use App\Services\FileService;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (App::environment('production')) {
            URL::forceScheme('https');
        }

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['it','en'])
                ->visible(outsidePanels: true)
                ->outsidePanelPlacement(Placement::TopRight)
                ->flags([
                    'it' => asset('images/flags/it.svg'),
                    'en' => asset('images/flags/en.svg'),
                ])
                ->flagsOnly()
                ->circular();
        });

        Filament::serving(function () {
            $arrNavigationGroups = [];
            $navigationGroups = \App\Models\NavigationGroup::select('id','slug','icon')->get();
            foreach($navigationGroups as $navigationGroup){
                $arrNavigationGroups[] = NavigationGroup::make()->label(fn (): string => __('navigation.'.$navigationGroup->slug))
                    ->icon("heroicon-o-".$navigationGroup->icon)
                    ->collapsed();
            }

            Filament::registerNavigationGroups($arrNavigationGroups);

            $product_categories = ProductCategory::select('id','slug')->get();
            foreach($product_categories as $product_category){
                Filament::registerNavigationItems([
                    NavigationItem::make()
                        ->label(__($product_category->slug.".navigation-label"))
                        ->url(fn (): string => ServiceResource::getUrl('index', ['product_category_id' => $product_category->id]))
                        ->group(__('services.navigation-group')),
                ]);
            }

            $sites = Site::select('id','name')->get();
            $order_type = OrderType::select('id')->where('slug', 'onsite')->first();

            foreach($sites as $site){
                Filament::registerNavigationItems([
                    NavigationItem::make()
                        ->label($site->name)
                        ->url(fn (): string => OrderResource::getUrl('create', ['site_id' => $site->id]))
                        ->group(__('orders.navigation-group')),
                ]);
            }

        });

    }

}
