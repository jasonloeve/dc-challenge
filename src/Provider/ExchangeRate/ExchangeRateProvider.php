<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Provider\ExchangeRate;

/**
 * Interface for providing exchange rates
 */
interface ExchangeRateProvider
{
    /**
     * Get exchange rate from one currency to another
     *
     * @param string $from Source currency code
     * @param string $to Target currency code
     * @return float Exchange rate
     * @throws \InvalidArgumentException If currency pair is not supported
     */
    public function getRate(string $from, string $to): float;

    /**
     * Check if a currency is supported
     *
     * @param string $currencyCode Currency code to check
     * @return bool
     */
    public function isSupported(string $currencyCode): bool;
}
