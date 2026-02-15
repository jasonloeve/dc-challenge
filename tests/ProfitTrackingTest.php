<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Tests;

use Docscentre\CurrencyConverter\Entity\Currency;
use Docscentre\CurrencyConverter\Service\CurrencyConverter;
use Docscentre\CurrencyConverter\Service\ProfitCalculator;
use Docscentre\CurrencyConverter\Provider\ExchangeRate\FixedExchangeRateProvider;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for ProfitCalculator service
 */
class ProfitTrackingTest extends TestCase
{
    private CurrencyConverter $converter;
    private ProfitCalculator $profitCalculator;

    protected function setUp(): void
    {
        $rateProvider = new FixedExchangeRateProvider();
        $this->converter = new CurrencyConverter($rateProvider);
        $this->profitCalculator = new ProfitCalculator($this->converter);
    }

    public function testCalculateProfitFromUsdToAud(): void
    {
        $usd = new Currency(100.0, 'USD');
        $aud = $this->converter->convert($usd, 'AUD');

        // @VALIDATE: 100 USD = 150 AUD, Profit = 15% of 150 AUD = 22.50 AUD
        $profit = $this->profitCalculator->calculateProfit($usd, $aud);

        $this->assertEquals(22.50, $profit);
    }

    public function testCalculateProfitFromAudToUsd(): void
    {
        $aud = new Currency(100.0, 'AUD');
        $usd = $this->converter->convert($aud, 'USD');

        // @VALIDATE: Profit is 15% of source in AUD = 15% of 100 AUD = 15.00 AUD
        $profit = $this->profitCalculator->calculateProfit($aud, $usd);

        $this->assertEquals(15.00, $profit);
    }

    public function testCalculateProfitFromGbpToEur(): void
    {
        $gbp = new Currency(100.0, 'GBP');
        $eur = $this->converter->convert($gbp, 'EUR');

        // @VALIDATE: 100 GBP = 170 AUD, Profit = 15% of 170 AUD = 25.50 AUD
        $profit = $this->profitCalculator->calculateProfit($gbp, $eur);

        $this->assertEquals(25.50, $profit);
    }

    public function testCalculateProfitFromAudToAud(): void
    {
        $aud = new Currency(100.0, 'AUD');
        $result = $this->converter->convert($aud, 'AUD');

        // @VALIDATE: Profit is 15% of 100 AUD = 15.00 AUD
        $profit = $this->profitCalculator->calculateProfit($aud, $result);

        $this->assertEquals(15.00, $profit);
    }
}
