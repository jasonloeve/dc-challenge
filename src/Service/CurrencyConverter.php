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
}
