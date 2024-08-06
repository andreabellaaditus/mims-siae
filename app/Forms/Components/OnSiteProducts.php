<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Component;

class OnSiteProducts extends Component
{
    protected string $view = 'forms.components.on-site-products';

    public static function make(): static
    {
        return app(static::class);
    }
}
