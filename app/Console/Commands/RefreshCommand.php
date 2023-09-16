<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class RefreshCommand extends Command
{

    protected $signature = 'shop:refresh';

    protected $description = 'Refresh';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if (app()->isProduction()) {
            return self::FAILURE;
        }

        $this->call('optimize:clear');

        Storage::deleteDirectory('images/products');
        Storage::deleteDirectory('images/brands');

        $this->call(
            'migrate:fresh',
            [
                '--seed' => true
            ]
        );

        return self::SUCCESS;
    }
}
