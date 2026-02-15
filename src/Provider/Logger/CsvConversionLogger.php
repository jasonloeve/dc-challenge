<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Provider\Logger;

use Docscentre\CurrencyConverter\Entity\Currency;

/**
 * Logs conversions to a CSV file
 */
class CsvConversionLogger implements ConversionLogger
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;

        // Create the file if it doesn't exist
        if (!file_exists($filePath)) {
            touch($filePath);
        }
    }

    public function log(Currency $from, Currency $to): void
    {
        $line = sprintf(
            "%s,%s\n",
            $from->__toString(),
            $to->__toString()
        );

        file_put_contents($this->filePath, $line, FILE_APPEND);
    }
}