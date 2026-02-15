<?php

declare(strict_types=1);

namespace Docscentre\CurrencyConverter\Config;

/**
 * Application configuration management
 * @NOTE - Very basic setup, would be in a env if built for a production setting.
 * @NOTE - In a real setting file naming would be dynamic based on needs and data management.
 */
class AppConfig
{
    /**
     * Get the path for the conversions CSV file
     *
     * @return string
     */
    public static function getConversionsFilePath(): string
    {
        // Check for environment variable first
        $envPath = getenv('CONVERSIONS_FILE');

        if ($envPath !== false && !empty($envPath)) {
            return $envPath;
        }

        // Default to var directory
        return dirname(__DIR__, 2) . '/data/conversions.csv';
    }
}
