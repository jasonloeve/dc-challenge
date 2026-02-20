<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Command;

use Docscentre\CurrencyConverter\Config\AppConfig;
use Docscentre\CurrencyConverter\Service\CurrencyConverter;
use Docscentre\CurrencyConverter\Service\ProfitCalculator;
use Docscentre\CurrencyConverter\Provider\ExchangeRate\FixedExchangeRateProvider;
use Docscentre\CurrencyConverter\Provider\Logger\CsvConversionLogger;

/**
 * Command for calculating profit from conversions
 *
 * Reads conversions from the CSV file and calculates total profit in specified currency
 * Company makes 15% profit from each conversion
 */
class ProfitCommand
{
    private ProfitCalculator $profitCalculator;
    private CsvConversionLogger $logger;
    private string $profitCurrency;

    public function __construct(
        ProfitCalculator $profitCalculator,
        CsvConversionLogger $logger,
        string $profitCurrency = 'AUD'
    ) {
        $this->profitCalculator = $profitCalculator;
        $this->logger = $logger;
        $this->profitCurrency = $profitCurrency;
    }

    /**
     * Execute the profit calculation command
     *
     * @return int Exit code
     */
    public function execute(): int
    {
        try {
            // Get all conversions
            $conversions = $this->logger->getConversions();

            if (empty($conversions)) {
                echo "No conversions found in the log file.\n";
                echo "Run some conversions first using: php bin/convert\n";
                return 0;
            }

            $totalProfit = 0.0;
            $conversionCount = count($conversions);

            echo "Conversion History & Profit Analysis\n";
            echo str_repeat('=', 60) . "\n\n";

            foreach ($conversions as $index => $conversion) {
                $from = $conversion['from'];
                $to = $conversion['to'];

                $profit = $this->profitCalculator->calculateProfit($from, $to, $this->profitCurrency);
                $totalProfit += $profit;

                echo sprintf(
                    "%d. %s → %s (Profit: %.2f %s)\n",
                    $index + 1,
                    $from,
                    $to,
                    $profit,
                    $this->profitCurrency
                );
            }

            echo "\n" . str_repeat('=', 60) . "\n";
            echo sprintf("Total Conversions: %d\n", $conversionCount);
            echo sprintf("Total Profit: %.2f %s\n", $totalProfit, $this->profitCurrency);
            echo str_repeat('=', 60) . "\n";

            return 0;
        } catch (\Exception $e) {
            return 1;
        }
    }

    /**
     * Create an instance with default dependencies
     *
     * @param string $profitCurrency Currency to display profit in (default: 'AUD')
     * @return self
     */
    public static function create(string $profitCurrency = 'AUD'): self
    {
        $rateProvider = new FixedExchangeRateProvider();
        $converter = new CurrencyConverter($rateProvider);
        $profitCalculator = new ProfitCalculator($converter);
        $logger = new CsvConversionLogger(AppConfig::getConversionsFilePath());

        return new self($profitCalculator, $logger, $profitCurrency);
    }
}
