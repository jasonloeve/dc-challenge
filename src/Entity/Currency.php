<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Entity;

/**
 * Represents a currency amount with conversion capabilities
 */
class Currency
{
    private float $amount;
    private string $code;

    public function __construct(float $amount, string $code)
    {
        $this->amount = $amount;
        $this->code = strtoupper($code);
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}