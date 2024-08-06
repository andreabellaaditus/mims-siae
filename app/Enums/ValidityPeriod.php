<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ValidityPeriod: string implements HasLabel
{
    case DAYS = 'days';
    case WEEKS = 'weeks';
    case MONTHS = 'months';
    case YEARS = 'years';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DAYS => __('enums.validity-periods.days'),
            self::WEEKS => __('enums.validity-periods.weeks'),
            self::MONTHS => __('enums.validity-periods.months'),
            self::YEARS => __('enums.validity-periods.years'),
        };
    }
}