<?php

declare(strict_types=1);

namespace MakeIT\LaravelCurrencyExtractor\Currency;

class CurrencyFactory implements CurrencyFactoryInterface
{
    public function create(string $content): Currency
    {
        return new Currency($content);
    }
}
