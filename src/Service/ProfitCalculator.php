<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Service;

use Docscentre\CurrencyConverter\Entity\Currency;

/**
 * Service for calculating profit from currency conversions
 */
class ProfitCalculator
{
    private const PROFIT_RATE = 0.15; // 15% profit @NOTE - We could have this in the config / env for future use cases.

    private CurrencyConverter $converter;

    public function __construct(CurrencyConverter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * Calculate profit in input currency
     * Profit is always 15% of the source amount in inputted currency
     *
     * @param Currency $from Original currency
     * @param Currency $to Converted currency (@NOTE unused but kept for interface compatibility)
     * @param string $profitCurrency Inputted currency. Default AUD
     * @return float Profit
     */
    public function calculateProfit(Currency $from, Currency $to, string $profitCurrency = 'AUD'): float
    {
        $profitInSourceCurrency = $from->getAmount() * self::PROFIT_RATE;

        $profitAmount = new Currency($profitInSourceCurrency, $from->getCode());
        $profitConverted = $this->converter->convert($profitAmount, $profitCurrency);

        return $profitConverted->getAmount();
    }
}
