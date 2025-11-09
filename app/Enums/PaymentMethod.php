<?php

namespace App\Enums;

enum PaymentMethod: int
{
    case COD = 1; // Cash on Delivery
    case CREDIT_CARD = 2;
    case PAYPAL = 3;
    case BANK_TRANSFER = 4;

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
