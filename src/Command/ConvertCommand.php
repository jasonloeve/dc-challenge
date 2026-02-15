<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Command;

use Docscentre\CurrencyConverter\Config\AppConfig;
use Docscentre\CurrencyConverter\Service\CurrencyConverter;
use Docscentre\CurrencyConverter\Provider\ExchangeRate\FixedExchangeRateProvider;
use Docscentre\CurrencyConverter\Provider\Logger\CsvConversionLogger;

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
