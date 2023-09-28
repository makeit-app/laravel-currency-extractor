<?php

/** @noinspection ALL */
declare(strict_types=1);

namespace MakeIT\LaravelCurrencyExtractor;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use MakeIT\LaravelCurrencyExtractor\Currency\CurrencyFactoryInterface;
use MakeIT\LaravelCurrencyExtractor\Provider\ProviderDTO;
use MakeIT\LaravelCurrencyExtractor\Provider\ProviderInterface;

class CurrencyExtractor implements CurrencyExtractorInterface
{
    private CurrencyFactoryInterface $currencyFactory;

    private ProviderInterface $provider;

    private $currency;

    private array $rates = [];

    public function __construct(CurrencyFactoryInterface $currencyFactory, ProviderInterface $provider)
    {
        $this->provider = $provider;
        $this->currencyFactory = $currencyFactory;
    }

    public function make(): CurrencyExtractorInterface
    {
        return $this;
    }

    public function fetchAndCache(string $key = 'currencies'): array
    {
        if (! Cache::has($key)) {
            // Extractibg the content from a provider
            $content = $this->currencyFactory->create($this->provider->fetch());
            // converting to array
            $array = json_decode($content->getContent(), true, 8, JSON_OBJECT_AS_ARRAY);
            // creating Data Transfer Object instance
            $DTO = new ProviderDTO($array, $this->provider);
            // extracting data as valid array
            $this->rates = $DTO->getRates();
            // if successfull extraction
            if (! empty($this->rates) && $this->rates[0] instanceof Carbon && ! empty($this->rates[1])) {
                // cacheing them
                Cache::put($key, $this->rates[1], $this->rates[0]->addHours(config('currency-extractor.cache_time')));
            }
        }

        // always returning data from cache
        return Cache::get($key);
    }

    public function getRates()
    {
        return $this->rates;
    }
}
