<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Tests;

use Docscentre\CurrencyConverter\Entity\Currency;
use Docscentre\CurrencyConverter\Service\CurrencyConverter;
use Docscentre\CurrencyConverter\Provider\ExchangeRate\FixedExchangeRateProvider;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for CurrencyConverter service
 */
class CurrencyConverterTest extends TestCase
{
    private CurrencyConverter $converter;

    protected function setUp(): void
    {
        $rateProvider = new FixedExchangeRateProvider();
        $this->converter = new CurrencyConverter($rateProvider);
    }

    public function testConvertUsdToAud(): void
    {
        $usd = new Currency(100.0, 'USD');
        $aud = $this->converter->convert($usd, 'AUD');

        $this->assertEquals(150.0, $aud->getAmount());
        $this->assertEquals('AUD', $aud->getCode());
    }

    public function testConvertAudToUsd(): void
    {
        $aud = new Currency(150.0, 'AUD');
        $usd = $this->converter->convert($aud, 'USD');

        $this->assertEquals(100.0, $usd->getAmount());
        $this->assertEquals('USD', $usd->getCode());
    }

    /**
     * @NOTE - Write tests for all conversion options ...
     */

    public function testConvertSameCurrency(): void
    {
        $aud = new Currency(100.0, 'AUD');
        $result = $this->converter->convert($aud, 'AUD');

        $this->assertEquals(100.0, $result->getAmount());
        $this->assertEquals('AUD', $result->getCode());
    }

    public function testThrowsExceptionForInvalidCurrency(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported currency pair');

        $invalid = new Currency(100.0, 'XXX');
        $this->converter->convert($invalid, 'AUD');
    }
}
