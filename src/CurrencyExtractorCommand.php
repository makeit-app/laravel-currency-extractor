<?php

declare(strict_types=1);

namespace MakeIT\LaravelCurrencyExtractor;

use Illuminate\Console\Command;
use MakeIT\LaravelCurrencyExtractor\Jobs\CurrencyCacheToDatabaseJob;

class CurrencyExtractorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makeit:currency-extractor:pull {--D|debug : Debug data in potput}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pulls exchange rates from the provider specified in the configuration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->timer = microtime(true);
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->_start();
        $this->usage();
        $this->msg(' ➥ Deleting the cache...');
        //CurrencyExtractorHelper::destroy_currencies();
        $this->usage();
        $this->msg(' ➥ Fetching Currencies...');
        $data = CurrencyExtractorHelper::fetch_currency();
        $this->msg(' ➥ Request Timestamp: '.$data[0]->format('Y-m-d H:i:s'));
        $this->newLine();
        dump($data[1]);
        $this->newLine();
        $this->usage();
        $this->msg(' ➥ Fill up the Database...');
        CurrencyCacheToDatabaseJob::dispatch();
        $this->newLine();
        $this->usage();
        $this->newLine();

        return 0;
    }

    protected function _start(): void
    {
        $this->newLine();
        $this->msg('Start At '.date('H:m:i d M Y'));
    }

    /**
     * Выводит типизированное сообщение с таймером времени работы скрипта
     */
    public function msg(string $text = '', string $type = 'info'): void
    {
        $t = round((microtime(true) - $this->timer), 2);
        $t = '[⏳'.sprintf('%05.2f', $t).'ms] '.$text;
        match ($type) {
            'info' => $this->info($t),
            'warn' => $this->warn($t),
            'error' => $this->error($t),
            'comment', 'line' => $this->line($t),
        };
    }

    /**
     * Выводит типизированное сообщение с таймером времени работы скрипта
     */
    protected function usage(): void
    {
        if ($this->option('debug')) {
            $this->msg(
                'MEMORY USAGE: '
                .round(memory_get_usage() / 1000000, 2)
                .'/'
                .round(memory_get_peak_usage(true) / 1000000, 2),
                'warn'
            );
        }
    }
}
