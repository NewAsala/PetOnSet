<?php

namespace App\Enums;

enum StatusEnum: string
{
    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
    
    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}