<?php

namespace App\Enums;

enum OrderAddressType: int
{
    case BILLING = 1;
    case SHIPPING = 2;

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
