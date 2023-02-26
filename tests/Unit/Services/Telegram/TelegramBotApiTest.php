<?php

declare(strict_types=1);

namespace Services\Telegram;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

final class TelegramBotApiTest extends TestCase
{
    /**
     * @return void
     */
    public function test_is_send_message_success(): void
    {
        Http::fake([
            TelegramBotApi::HOST . '*' => Http::response(['ok' => true])
        ]);

        $result = TelegramBotApi::sendMessage('');

        $this->assertTrue($result);
    }
}
