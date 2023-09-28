<?php

declare(strict_types=1);

namespace MakeIT\LaravelCurrencyExtractor;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use MakeIT\LaravelCurrencyExtractor\Currency\CurrencyFactory;
use MakeIT\LaravelCurrencyExtractor\Currency\CurrencyFactoryInterface;
use MakeIT\LaravelCurrencyExtractor\Models\Currency;
use MakeIT\LaravelCurrencyExtractor\Provider\ProviderInterface;

class CurrencyExtractorServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     */
    public array $bindings = [
        CurrencyFactoryInterface::class => CurrencyFactory::class,
        CurrencyExtractorInterface::class => CurrencyExtractor::class,
    ];

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CurrencyExtractorCommand::class,
            ]);
            $this->publishes([__DIR__.'/../config/currency-extractor.php' => config_path('currency-extractor.php')], 'config');
            $this->publishes([__DIR__.'/Observers/CurrencyObserver.php' => app_path('Observers/CurrencyObserver.php')], 'observers');
            $this->publishes([__DIR__.'/Policies/CurrencyPolicy.php' => app_path('Policies/CurrencyPolicy.php')], 'policies');
            $this->publishes([__DIR__.'/NovaCurrencies.php' => app_path('Nova/NovaCurrencies.php')], 'nova');
        }
        $this->app->bind(ProviderInterface::class, config('currency-extractor.provider_class'));
        $this->app->alias(CurrencyExtractorInterface::class, 'currency.extractor');
        $this->registerObservers();
        $this->registerPolicies();
        $this->app->make('config')->set('logging.channels.currency-extractor', [
            'driver' => 'daily',
            'path' => storage_path('logs/currency-extractor/currency-extractor.log'),
            'level' => 'debug',
            'days' => 7,
        ]);
    }

    public function registerObservers(): void
    {
        if (file_exists(app_path('Observers/CurrencyObserver.php'))) {
            /** @noinspection PhpFullyQualifiedNameUsageInspection */
            /** @noinspection PhpUndefinedConstantInspection */
            Currency::observe(\App\Observers\CurrencyObserver::class);
        }
    }

    public function registerPolicies(): void
    {
        if (file_exists(app_path('Policies/CurrencyPolicy.php'))) {
            /** @noinspection PhpFullyQualifiedNameUsageInspection */
            /** @noinspection PhpUndefinedConstantInspection */
            Gate::policy(Currency::class, \App\Policies\CurrencyPolicy::class);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/currency-extractor.php', 'currency-extractor');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
