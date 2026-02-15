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
        if ($amount < 0) {
            throw new \InvalidArgumentException('Amount cannot be negative');
        }

        $code = trim($code);

        if (empty($code)) {
            throw new \InvalidArgumentException('Currency code cannot be empty');
        }

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

    // @NOTE - Look at built in or moving this to a global, currently has tight coupling and violates SOLID principles.
    public function __toString(): string
    {
        return sprintf('%.2f %s', $this->amount, $this->code);
    }
}
