<?php

namespace App\Enums;

enum VacationDay: string
{
    case SUNDAY = 'sunday';
    case MONDAY = 'monday';
    case TUESDAY = 'tuesday';
    case WEDNESDAY = 'wednesday';
    case THURSDAY = 'thursday';
    case FRIDAY = 'friday';
    case SATURDAY = 'saturday';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
