<?php

declare(strict_types=1);

namespace MakeIT\LaravelCurrencyExtractor\Currency;

interface CurrencyInterface
{
    public function getContent(): string;
}
