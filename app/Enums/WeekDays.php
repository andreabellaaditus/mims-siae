<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum WeekDays: string implements HasLabel
{
    case MONDAY = 'lun';
    case TUESDAY = 'mar';
    case WEDNESDAY = 'mer';
    case THURSDAY = 'gio';
    case FRIDAY = 'ven';
    case SATURDAY = 'sab';
    case SUNDAY = 'dom';
    case HOLIDAYS = 'hol';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MONDAY => __('enums.weekdays.monday'),
            self::TUESDAY => __('enums.weekdays.tuesday'),
            self::WEDNESDAY => __('enums.weekdays.wednesday'),
            self::THURSDAY => __('enums.weekdays.thursday'),
            self::FRIDAY => __('enums.weekdays.friday'),
            self::SATURDAY => __('enums.weekdays.saturday'),
            self::SUNDAY => __('enums.weekdays.sunday'),
            self::HOLIDAYS => __('enums.weekdays.holidays'),
        };
    }
}
