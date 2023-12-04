<?php

namespace MakeIT\LaravelCurrencyExtractor\Jobs;

use App\Sorter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use Log;
use MakeIT\LaravelCurrencyExtractor\Models\Currency;

class CurrencyCacheToDatabaseJob
{
    use Dispatchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // get cache data and flush them
        $Cached = Cache::pull('currencies');
        if (!is_null($Cached)) {
            $codes = array_keys($Cached);
            $Currencies = Currency::whereIn('code', $codes)->get();
            if (count($Currencies)) {
                foreach ($Cached as $code => $rate) {
                    $this->updateCurrency($Currencies, $code, $rate);
                }
            } else {
                $x = 0;
                foreach ($Cached as $code => $rate) {
                    $x++;
                    $this->createCurrency($code, $rate, $x);
                }
            }
        }
    }

    protected function updateCurrency(Collection $Currencies, string $code, float $rate): void
    {
        $Currency = $Currencies->where('code', $code)->first();
        if (!is_null($Currency)) {
            $Currency->base = config('currency-extractor.base');
            $Currency->rate = $rate;
            $Currency->save();
            $upd = $Currency->isDirty() ? $Currency->updated_at->toString() : false;
            if (config('currency-extractor.logging')) {
                Log::channel('currency-extractor')->info([
                    'code' => $code,
                    '%new' => $rate,
                    'date' => $upd,
                ]);
            }
        }
    }

    protected function createCurrency(string $code, float $rate, int $x = 0): void
    {
        $Currency = Currency::create([
            'code' => $code,
            'is_active' => false,
            'base' => config('currency-extractor.base'),
            'rate' => $rate,
            Sorter::FIELD => $x,
        ]);
        if (config('currency-extractor.logging')) {
            Log::channel('currency-extractor')->info([
                'code' => $code,
                '+new' => $rate,
                'date' => $Currency->created_at->toString(),
            ]);
        }
    }
}
