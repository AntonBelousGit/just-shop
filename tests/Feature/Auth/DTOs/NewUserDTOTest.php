<?php

declare(strict_types=1);

namespace Auth\DTOs;

use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class NewUserDTOTest extends TestCase
{
    use RefreshDatabase;

    public function test_instance_created_from_form_request(): void
    {
        $dto = NewUserDTO::fromRequest(new SignUpFormRequest([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => '1234567890'
        ]));

        $this->assertInstanceOf(NewUserDTO::class, $dto);
    }
}
