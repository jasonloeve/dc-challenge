<?php

declare(strict_types=1);

use Docscentre\CurrencyConverter\Entity\Currency;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Currency entity
 */
class CurrencyTest extends TestCase
{
    public function testCanCreateCurrency(): void
    {
        $currency = new Currency(100.0, 'USD');

        $this->assertEquals(100.0, $currency->getAmount());
        $this->assertEquals('USD', $currency->getCode());
    }
}
