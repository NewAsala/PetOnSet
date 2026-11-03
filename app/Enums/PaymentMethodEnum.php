<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case CASH = 'Cash';
    case BY_WHISH = 'By_Whish';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
