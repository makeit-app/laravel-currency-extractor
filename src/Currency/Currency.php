<?php

declare(strict_types=1);

namespace MakeIT\LaravelCurrencyExtractor\Currency;

class Currency implements CurrencyInterface
{
    private string $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
