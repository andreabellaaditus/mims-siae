<?php

namespace App\Providers\Filament;

use App\Filament\ServiceResource;
use App\Models\ProductCategory;
use Filament\Navigation\NavigationBuilder;
use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;
use Swis\Filament\Backgrounds\ImageProviders\MyImages;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use App\Services\FileService;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()
            ->passwordReset()
            //->emailVerification()
            ->colors([
                'primary' => Color::Amber,
                'secondary' => Color::Indigo,
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->font('Montserrat')
            ->discoverResources(in: app_path('Filament/ResourcesSiae'), for: 'App\\Filament\\ResourcesSiae')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            //->sidebarCollapsibleOnDesktop()
            ->userMenuItems([
                //'profile' => MenuItem::make()->label('Edit profile'),
            ])
            ->brandName('MIMS')
            //->brandLogo(fn () => view('admin.logo-light'))
            //->darkModeBrandLogo(fn () => view('admin.logo-dark'))
            //->brandLogo(asset('images/logo/aditus-light.svg'))
            //->darkModeBrandLogo(asset('images/logo/aditus-dark.svg'))
            ->plugins([
                FilamentBackgroundsPlugin::make()
                    ->imageProvider(
                        MyImages::make()
                            ->directory('images/backgrounds')
                    ),
                EnvironmentIndicatorPlugin::make()
                    ->visible(true)
                    ->color(fn () => match (app()->environment()) {
                        'production' => null,
                        'staging' => Color::Orange,
                        default => Color::Amber,
                    }),
            ])
            ->resources([
                config('filament-logger.activity_resource')
            ])
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
