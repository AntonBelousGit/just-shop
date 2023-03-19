<?php

declare(strict_types=1);

namespace Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class RegisterNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_user_is_created(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => 'test@gmail.com'
        ]);

        $action = app(RegisterNewUserContract::class);

        $action(NewUserDTO::make('TestUser', 'test@gmail.com', '123456790'));

        $this->assertDatabaseHas('users', [
            'email' => 'test@gmail.com'
        ]);
    }
}
