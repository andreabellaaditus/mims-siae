<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Arr;
use ReflectionClass;

enum SaleClient: string implements HasLabel
{
    case CUSTOMERS = 'customers';
    case AGENCIES = 'agencies';
    case SCHOOLS = 'schools';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CUSTOMERS => __('enums.sale-clients.customers'),
            self::AGENCIES => __('enums.sale-clients.agencies'),
            self::SCHOOLS => __('enums.sale-clients.schools'),
        };
    }



}
