<?php

declare(strict_types=1);

namespace MakeIT\LaravelCurrencyExtractor\Facades;

use Illuminate\Support\Facades\Facade;
use MakeIT\LaravelCurrencyExtractor\CurrencyExtractor;

class CurrencyExtractorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        return CurrencyExtractor::class;
    }
}
