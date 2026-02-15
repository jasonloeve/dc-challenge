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
        $fromInAud = $this->converter->convert($from, 'AUD');

        return $fromInAud->getAmount() * self::PROFIT_RATE;
    }
}
