<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ReductionType: string implements HasLabel
{
    case FREE = 'free';
    case REDUCED = 'reduced';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FREE => __('enums.reduction-types.free'),
            self::REDUCED => __('enums.reduction-types.reduced'),
        };
    }

}