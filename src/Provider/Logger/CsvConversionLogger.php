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

    /**
     * @NOTE:
     * In a production with we would have dynamic naming, we would also
     * likely log more info e.g ID, user ID, date time stamp.
     */
    public function log(Currency $from, Currency $to): void
    {
        $line = sprintf(
            "%s,%s\n",
            $from->__toString(),
            $to->__toString()
        );

        file_put_contents($this->filePath, $line, FILE_APPEND);
    }

    public function getConversions(): array
    {
        if (!file_exists($this->filePath) || filesize($this->filePath) === 0) {
            return [];
        }

        $conversions = [];
        $lines = file($this->filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $parts = explode(',', trim($line));

            if (count($parts) !== 2) {
                continue;
            }

            // Parse "100.00 USD" format
            $fromParts = explode(' ', trim($parts[0]));
            $toParts = explode(' ', trim($parts[1]));

            if (count($fromParts) === 2 && count($toParts) === 2) {
                $conversions[] = [
                    'from' => new Currency((float)$fromParts[0], $fromParts[1]),
                    'to' => new Currency((float)$toParts[0], $toParts[1]),
                ];
            }
        }

        return $conversions;
    }
}
