<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Requests\SignInFormRequest;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignInControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_login_page_success(): void
    {
        $this->get(action([SignInController::class, 'page']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    public function test_handle_success(): void
    {
        $password = '1234567890';

        $user = UserFactory::new()->create([
            'email' => 'test@gmail.com',
            'password' => bcrypt($password)
        ]);

        $request = SignInFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $password
        ]);

        $response = $this->post(action([SignInController::class, 'handle']), $request);

        $response->assertValid()->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_handle_failure(): void
    {
        $request = SignInFormRequest::factory()->create([
            'email' => 'test@gmail.com',
            'password' => str()->random(10)
        ]);

        $this->post(action([SignInController::class, 'handle']), $request)
            ->assertInValid(['email']);

        $this->assertGuest();
    }

    public function test_logout_success(): void
    {
        $user = UserFactory::new()->create([
            'email' => 'test@gmail.com',
        ]);

        $this->actingAs($user)->delete(action([SignInController::class, 'logOut']));

        $this->assertGuest();
    }

    public function test_logout_guest_middleware_fail(): void
    {
        $this->delete(action([SignInController::class, 'logOut']))
            ->assertRedirect(route('home'));
    }
}
