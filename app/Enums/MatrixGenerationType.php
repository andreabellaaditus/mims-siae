<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MatrixGenerationType: string implements HasLabel
{
    case PRELOADED = 'generated';
    case ONREQUEST = 'on_request';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PRELOADED => __('enums.matrices-generation-types.pre-loaded'),
            self::ONREQUEST => __('enums.matrices-generation-types.on-request'),
        };
    }
}