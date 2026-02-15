<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Command;

use Docscentre\CurrencyConverter\Config\AppConfig;
use Docscentre\CurrencyConverter\Service\CurrencyConverter;
use Docscentre\CurrencyConverter\Provider\ExchangeRate\FixedExchangeRateProvider;
use Docscentre\CurrencyConverter\Provider\Logger\CsvConversionLogger;
use Docscentre\CurrencyConverter\Entity\Currency;

/**
 * Command for converting currencies
 */
class ConvertCommand
{
    private CurrencyConverter $converter;
    private CsvConversionLogger $logger;

    public function __construct(
        CurrencyConverter $converter,
        CsvConversionLogger $logger
    ) {
        $this->converter = $converter;
        $this->logger = $logger;
    }

    /**
     * Execute the conversion command
     *
     * @param array $args Command line arguments
     * @return int Exit code
     */
    public function execute(array $args): int
    {
        // Validate arguments
        if (count($args) !== 4) {
            $this->showUsage();
            return 1;
        }

        $amount = (float)$args[1];
        $fromCode = $args[2];
        $toCode = $args[3];

        try {
            // Create source currency
            $fromCurrency = new Currency($amount, $fromCode);

            // Convert
            $toCurrency = $this->converter->convert($fromCurrency, $toCode);

            // Log the conversion
            $this->logger->log($fromCurrency, $toCurrency);

            // Display result
            echo sprintf(
                "Converted: %s → %s\n",
                $fromCurrency,
                $toCurrency
            );

            return 0;
        } catch (\InvalidArgumentException $e) {
            echo "Error: {$e->getMessage()}\n";
            echo "\nSupported currencies: AUD, USD, NZD, GBP, EUR\n";
            return 1;
        } catch (\Exception $e) {
            echo "An error occurred: {$e->getMessage()}\n";
            return 1;
        }
    }

    /**
     * Show usage information
     */
    private function showUsage(): void
    {
        echo "Usage: php bin/convert <amount> <from_currency> <to_currency>\n";
        echo "Example: php bin/convert 100 USD AUD\n";
    }

    /**
     * Create an instance with default dependencies
     *
     * @return self
     */
    public static function create(): self
    {
        $rateProvider = new FixedExchangeRateProvider();
        $converter = new CurrencyConverter($rateProvider);
        $logger = new CsvConversionLogger(AppConfig::getConversionsFilePath());

        return new self($converter, $logger);
    }
}
