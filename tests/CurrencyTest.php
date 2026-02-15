<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Tests;

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

    public function testThrowsExceptionForNegativeAmount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Amount cannot be negative');

        new Currency(-10.0, 'USD');
    }

    public function testThrowsExceptionForEmptyCurrencyCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Currency code cannot be empty');

        new Currency(100.0, '');
    }

    /**
     * @NOTES - further tests as needed
     * - Uppercase conversion - strtoupper
     * - Whitespace currency code test ?
     * - Zero value test ?
     * - Test value is string ?
     */

}
