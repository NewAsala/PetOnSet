<?php

namespace App\Enums;

enum PaidEnum: string
{
    case PAID = 'Paid';
    case PARTIALLY_PAID = 'Partially Paid';
    case UNPAID = 'Unpaid';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
