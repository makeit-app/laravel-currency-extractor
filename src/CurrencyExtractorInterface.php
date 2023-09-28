<?php

declare(strict_types=1);

namespace MakeIT\LaravelCurrencyExtractor;

interface CurrencyExtractorInterface
{
    /**
     * @return $this
     */
    public function make(): self;

    public function fetchAndCache(): array;
}
