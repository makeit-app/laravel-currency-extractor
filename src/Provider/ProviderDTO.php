<?php

declare(strict_types=1);

namespace MakeIT\LaravelCurrencyExtractor\Provider;

use Carbon\Carbon;

class ProviderDTO
{
    public function __construct(protected array $array, protected ProviderInterface $provider)
    {
    }

    public function getRates(): array
    {
        if ($this->provider instanceof CbrProvider) {
            return $this->getFromCbr();
        }

        return [];
    }

    protected function getFromCbr(): array
    {
        $output = [];
        $dated = Carbon::now();
        if (! empty($this->array['rates'])) {
            foreach ($this->array['rates'] as $code => $rate) {
                if (in_array($code, config('currency-extractor.valutes'))) {
                    $output[$code] = $rate;
                }
            }
        }

        return [
            $dated,
            $output,
        ];
    }
}
