<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class TelegramBotApi
{
    /**
     * Telegram API host
     */
    public const HOST = 'https://api.telegram.org/bot';

    /**
     * Send message via telegram
     * @param string $message
     */
    public static function sendMessage(string $message): void
    {
        try {
            $result = Http::get(
                self::HOST . config('telegram.token') . '/1sendMessage',
                [
                    'chat_id' => config('telegram.chatId'),
                    'text' => $message
                ]
            );

            if ($result->getStatusCode() !== 200) {
                $errors = $result->getBody()->getContents();
                Log::info(['error' => $errors, 'from' => 'App\Services\Telegram\TelegramBotApi']);
            }
        } catch (Exception $e) {
            Log::info(['error' => $e, 'from' => 'App\Services\Telegram\TelegramBotApi']);
        }
    }
}
