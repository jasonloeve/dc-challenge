# Currency Converter

A PHP command-line application for converting currencies and tracking conversion profits.

## Requirements

- PHP 7.4 or higher
- Composer

## Installation

```bash
composer install
```

## Usage

### Challenge 1: Currency Conversion

Convert between supported currencies using the command line:

```bash
php bin/convert <amount> <from_currency> <to_currency>
```

**Example:**
```bash
php bin/convert 100 USD AUD
# Output: Converted: 100.00 USD → 150.00 AUD
```

The conversion will be logged to `data/conversions.csv` for profit tracking.

### Challenge 2: Profit Calculation

Calculate total profit from all conversions:

```bash
php bin/profit
```

This reads the conversion log and displays profit for each transaction. The company makes 15% profit on each conversion, calculated in AUD.

## Running Tests

The project includes PHPUnit tests covering the core functionality:

```bash
vendor/bin/phpunit
```

For a readable test summary:

```bash
vendor/bin/phpunit --testdox
```
