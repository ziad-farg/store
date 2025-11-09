<?php

namespace App\Enums;

enum PaymentStatus: int
{
    case PENDING = 1;
    case PAID = 2;
    case FAILED = 3;

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
