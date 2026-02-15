<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Provider\ExchangeRate;

/**
 * Provides fixed exchange rates based on AUD as the base currency
 */
class FixedExchangeRateProvider implements ExchangeRateProvider
{
    /**
     * @NOTE - In a real world setting these would likely be pulled from live api
     * (dynamic values), logically giving a user x minutes to proceed with action,
     * if passed then will have to request new current values / validate.
     */
    private const RATES_TO_AUD = [
        'USD' => 1.5,   // 1 USD = 1.5 AUD
        'NZD' => 0.9,   // 1 NZD = 0.9 AUD
        'GBP' => 1.7,   // 1 GBP = 1.7 AUD
        'EUR' => 1.5,   // 1 EUR = 1.5 AUD
        'AUD' => 1.0,   // 1 AUD = 1.0 AUD
    ];

    public function getRate(string $from, string $to): float
    {
        $from = strtoupper($from);
        $to = strtoupper($to);

        if (!$this->isSupported($from) || !$this->isSupported($to)) {
            throw new \InvalidArgumentException(
                "Unsupported currency pair: {$from} to {$to}"
            );
        }

        if ($from === $to) {
            return 1.0;
        }

        // Convert from -> AUD -> to
        // If converting FROM USD to AUD: 100 USD * 1.5 = 150 AUD
        // If converting FROM AUD to USD: 100 AUD / 1.5 = 66.67 USD
        $fromToAud = self::RATES_TO_AUD[$from];
        $toToAud = self::RATES_TO_AUD[$to];

        return $fromToAud / $toToAud;
    }

    public function isSupported(string $currencyCode): bool
    {
        return isset(self::RATES_TO_AUD[strtoupper($currencyCode)]);
    }
}