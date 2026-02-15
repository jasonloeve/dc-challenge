<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Provider\Logger;

use Docscentre\CurrencyConverter\Entity\Currency;

/**
 * Interface for logging currency conversions
 */
interface ConversionLogger
{
    /**
     * Log a conversion
     *
     * @param Currency $from Original currency
     * @param Currency $to Converted currency
     * @return void
     */
    public function log(Currency $from, Currency $to): void;

    /**
     * Get all logged conversions
     *
     * @return array Array of conversions [['from' => Currency, 'to' => Currency], ...]
     */
    public function getConversions(): array;
}
