<?php

use MakeIT\LaravelCurrencyExtractor\Provider\CbrProvider;

return [
    /*
     |--------------------------------------------------------------------------
     | Currency Provider
     |--------------------------------------------------------------------------
     |
     | This class is used for fetching currencies. You can swap it out easily if
     | you like as long as you implement the ProviderInterface.
     |
     | \MakeIT\LaravelCurrencyExtractor\Provider\ProviderInterface
     |
     */
    'provider_class' => CbrProvider::class,
    /*
     |--------------------------------------------------------------------------
     | Valutes to Fetch from Provider Output
     |--------------------------------------------------------------------------
     */
    'valutes' => [
        'RUB',
        'EUR',
        'USD',
        'CNY',
    ],
    /*
     |--------------------------------------------------------------------------
     | Cacheing Time in Hours
     |--------------------------------------------------------------------------
     */
    'cache_time' => 4,
    /*
     |--------------------------------------------------------------------------
     | Base Currency for calculations
     |--------------------------------------------------------------------------
     */
    'base' => 'RUB',
    /*
     |--------------------------------------------------------------------------
     | Logging updates
     |--------------------------------------------------------------------------
     |
     | If true, ServiceProvider will create additionsl logging channel and
     | scripts, where allowed, will log their actions
     |
     */
    'logging' => false,
];
