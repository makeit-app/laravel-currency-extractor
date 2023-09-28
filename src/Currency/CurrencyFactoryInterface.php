<?php

declare(strict_types=1);

namespace MakeIT\LaravelCurrencyExtractor\Currency;

interface CurrencyFactoryInterface
{
    public function create(string $content): Currency;
}
