<?php

declare(strict_types=1);

namespace Support\Logging\Telegram;

use Services\Telegram\TelegramBotApi;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

final class TelegramLoggerHandler extends AbstractProcessingHandler
{
    /**
     * TelegramLoggerHandler constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level);
    }

    /**
     * @param array $record
     */
    protected function write(array $record): void
    {
        TelegramBotApi::sendMessage($record['formatted']);
    }
}
