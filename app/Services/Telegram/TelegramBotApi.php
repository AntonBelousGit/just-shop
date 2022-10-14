<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    /**
     * @param string $message
     */
    public static function sendMessage(string $message): void
    {
        try {
            Http::get(
                self::HOST . config('telegram.token') . '/sendMessage',
                [
                    'chat_id' => config('telegram.chatId'),
                    'text' => $message
                ]
            );
        } catch (Exception $e) {
            Log::info(['error' => $e, 'from' => 'App\Services\Telegram\TelegramBotApi']);
        }
    }
}
