<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING = 1;
    case PROCESSING = 2;
    case COMPLETED = 3;
    case CANCELLED = 4;
    case REFUNDED = 5;
    case DELIVERING = 6;

    // ------------------------------------------------------------------
    // Static helpers
    // ------------------------------------------------------------------
    public static function keyValueMap(): array
    {
        $map = [];
        foreach (self::cases() as $case) {
            $map[$case->name] = $case->value;
        }

        return $map;
    }

    public static function keys(): array
    {
        return array_map(fn ($c) => $c->name, self::cases());
    }

    public static function values(): array
    {
        return array_map(fn ($c) => $c->value, self::cases());
    }
}
