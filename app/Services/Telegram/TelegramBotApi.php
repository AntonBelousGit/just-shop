<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use App\Services\Telegram\Exceptions\TelegramBotApiException;
use Illuminate\Support\Facades\Http;
use Throwable;

final class TelegramBotApi
{
    /**
     * Telegram API host
     */
    public const HOST = 'https://api.telegram.org/bot';

    /**
     * Send message via telegram
     * @param string $message
     * @return bool
     */
    public static function sendMessage(string $message): bool
    {
        try {
            $result = Http::get(
                self::HOST . config('telegram.token') . '/sendMessage',
                [
                    'chat_id' => config('telegram.chatId'),
                    'text' => $message
                ]
            )->throw()->json();

            return $result['ok'] ?? false;
        } catch (Throwable $e) {
            report(new TelegramBotApiException($e->getMessage()));

            return false;
        }
    }
}
