<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SaleChannel: string implements HasLabel
{
    case ONLINE = 'online';
    case ONSITE = 'onsite';
    case CRM = 'crm';
    case TVM = 'tvm';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ONLINE => __('enums.sale-channels.online'),
            self::ONSITE => __('enums.sale-channels.onsite'),
            self::CRM => __('enums.sale-channels.crm'),
            self::TVM => __('enums.sale-channels.tvm'),
        };
    }

}
