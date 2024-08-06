<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FrequencyType: string implements HasLabel
{
    case ONFLY = 'on-fly';
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ONFLY => __('enums.frequency-types.on-fly'),
            self::DAILY => __('enums.frequency-types.daily'),
            self::WEEKLY => __('enums.frequency-types.weekly'),
            self::MONTHLY => __('enums.frequency-types.monthly'),
            self::YEARLY => __('enums.frequency-types.yearly'),
        };
    }
}