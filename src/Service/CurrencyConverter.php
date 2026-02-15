<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Service;

use Docscentre\CurrencyConverter\Entity\Currency;
use Docscentre\CurrencyConverter\Provider\ExchangeRate\ExchangeRateProvider;

/**
 * Service for converting currencies
 */
class CurrencyConverter
{
    private const PROFIT_RATE = 0.15; // 15% profit @NOTE - We could have this in the config / env for future use cases.

    private ExchangeRateProvider $rateProvider;

    public function __construct(ExchangeRateProvider $rateProvider)
    {
        $this->rateProvider = $rateProvider;
    }

    /**
     * Convert currency from one type to another
     *
     * @param Currency $from Source currency
     * @param string $targetCode Target currency code
     * @return Currency Converted currency
     * @throws \InvalidArgumentException
     */
    public function convert(Currency $from, string $targetCode): Currency
    {
        $rate = $this->rateProvider->getRate($from->getCode(), $targetCode);
        $convertedAmount = $from->getAmount() * $rate;

        return new Currency($convertedAmount, $targetCode);
    }

    /**
     * Calculate profit in AUD from a conversion
     * Profit is always 15% of the source amount in AUD
     *
     * @param Currency $from Original currency
     * @param Currency $to Converted currency (@NOTE unused but kept for interface compatibility)
     * @return float Profit in AUD
     */
    public function calculateProfit(Currency $from, Currency $to): float
    {
        // Profit is 15% of the source amount in AUD
        if ($from->getCode() === 'AUD') {
            return $from->getAmount() * self::PROFIT_RATE;
        }

        // Convert source to AUD first
        $fromInAud = $this->convert($from, 'AUD');

        return $fromInAud->getAmount() * self::PROFIT_RATE;
    }
}
