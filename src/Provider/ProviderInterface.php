<?php

declare(strict_types=1);

namespace MakeIT\LaravelCurrencyExtractor\Provider;

interface ProviderInterface
{
    public function fetch(): string;

    public function getFromValute(): string;
}
