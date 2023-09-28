# Laravel Currency Extractor

# Installation

```bash
composer require make-it-app/laravel-currency-extractor
php artisan vendor:publish --provider="MakeIT\LaravelCurrencyExtractor\CurrencyExtractorServiceProvider" --tag="config"
```
**Please observe the config-file first!**

If You plan to work with:<br>
- Observers: `php artisan vendor:publish --provider="MakeIT\LaravelCurrencyExtractor\CurrencyExtractorServiceProvider" --tag="observers"` You are free to mod this file after publishing!
- Policies: `php artisan vendor:publish --provider="MakeIT\LaravelCurrencyExtractor\CurrencyExtractorServiceProvider" --tag="policies"` You are free to mod this file after publishing!
- Laravel Nova: `php artisan vendor:publish --provider="MakeIT\LaravelCurrencyExtractor\CurrencyExtractorServiceProvider" --tag="nova"` Attention, tested only on Nova 4! You are free to mod this file after publishing!

# Usage

See `src/CurrencyExtractorHelper.php`<br>
or
```php
$extractor = CurrencyExtractor::make();
$extractor->fetchAndCache( $key );
return $extractor->getRates();
```
Or (recommended)
```bash
php artisan makeit:currency-extractor:pull
```
it will pull the exchange rates from external data provider, put it into Cache and create (or update, when exists) a Database records

# LICENSE MIT
