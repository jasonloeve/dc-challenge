<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Command;

use Docscentre\CurrencyConverter\Config\AppConfig;
use Docscentre\CurrencyConverter\Service\CurrencyConverter;
use Docscentre\CurrencyConverter\Provider\ExchangeRate\FixedExchangeRateProvider;
use Docscentre\CurrencyConverter\Provider\Logger\CsvConversionLogger;

/**
 * Command for calculating profit from conversions
 *
 * Reads conversions from the CSV file and calculates total profit in AUD
 * Company makes 15% profit from each conversion
 */
class ProfitCommand
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
     * Execute the profit calculation command
     *
     * @return int Exit code
     */
    public function execute(): int
    {
        return 0;
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
