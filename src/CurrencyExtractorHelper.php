<?php

namespace MakeIT\LaravelCurrencyExtractor;

use Cache;
use CurrencyExtractor;
use MakeIT\LaravelCurrencyExtractor\Jobs\CurrencyCacheToDatabaseJob;

class CurrencyExtractorHelper
{
    public static function fetch_currency(string $key = 'currencies', bool $force_logging = false): array
    {
        if ($force_logging) {
            config()->set('currency-extractor.logging', true);
        }
        $extractor = CurrencyExtractor::make();
        $extractor->fetchAndCache($key);
        CurrencyCacheToDatabaseJob::dispatch();

        return $extractor->getRates();
    }

    public static function destroy_currencies(string $key = 'currencies'): bool
    {
        return Cache::forget($key);
    }
}

/*
 * USAGE:
 * \MakeIT\LaravelCurrencyExtractor\CurrencyExtractorHelper::fetch_currency( 'cbr_currencies' );
 * \MakeIT\LaravelCurrencyExtractor\CurrencyExtractorHelper::destroy_currencies( 'cbr_currencies' );
 * \Cache::get( 'cbr_currencies );
 *
 * Try it in the Tinker !
 */
