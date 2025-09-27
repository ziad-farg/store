<?php

namespace App\Helpers;

use NumberFormatter;

class Currency
{
    /**
     * Format a given amount into a currency string.
     *
     * @param float $amount The amount to format.
     * @param string|null $currency The currency code (e.g., 'USD', 'EUR'). If null, defaults to app currency.
     * @return string The formatted currency string.
     */
    public static function format($amount, $currency = null)
    {
        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);

        $currency = $currency ?? config('app.currency', 'USD');

        return $formatter->formatCurrency($amount, $currency);
    }
}
