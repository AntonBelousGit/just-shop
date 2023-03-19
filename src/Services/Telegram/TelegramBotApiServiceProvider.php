<?php

declare(strict_types=1);

namespace Services\Telegram;

use App\Services\FlavorService\Contracts\FlavorServiceContract;
use App\Services\FlavorService\Contracts\FlavorValidatorContract;
use App\Services\FlavorService\FlavorService;
use App\Services\FlavorService\FlavorValidator;
use Illuminate\Support\ServiceProvider;
use Services\Telegram\Contracts\TelegramBotApiContract;

class TelegramBotApiServiceProvider extends ServiceProvider
{
    /**
     * Register port services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(TelegramBotApiContract::class, TelegramBotApi::class);
    }
}
