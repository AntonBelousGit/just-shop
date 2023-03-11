<?php

namespace App\Http\Controllers\Auth;

use Database\Factories\UserFactory;
use DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Mockery\MockInterface;
use Tests\TestCase;

class SocialAuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private function mockSocialiteCallback(string|int $githubId): MockInterface
    {
        $user = $this->mock(SocialiteUser::class, function (MockInterface $m) use ($githubId) {
            $m->expects('getId')
                ->andReturns($githubId);

            $m->expects('getName')
                ->andReturns(str()->random(10));

            $m->expects('getEmail')
                ->andReturns('test@gmail.com');
        });

        Socialite::shouldReceive('driver->user')
            ->once()
            ->andReturn($user);

        return $user;
    }

    private function callbackRequest(): TestResponse
    {
        return $this->get(
            action(
                [SocialAuthController::class, 'callback'],
                ['driver' => 'github']
            )
        );
    }

    public function test_github_redirect_success(): void
    {
        $this->get(
            action(
                [SocialAuthController::class, 'redirect'],
                ['driver' => 'github']
            )
        )->assertRedirectContains('github.com');
    }

    public function test_driver_not_found_exception(): void
    {
        $this->expectException(DomainException::class);

        $this
            ->withoutExceptionHandling()
            ->get(
                action(
                    [SocialAuthController::class, 'redirect'],
                    ['driver' => 'i.ua']
                )
            );

        $this
            ->withoutExceptionHandling()
            ->get(
                action(
                    [SocialAuthController::class, 'callback'],
                    ['driver' => 'i.ua']
                )
            );
    }

    public function test_github_callback_created_user_success(): void
    {
        $githubId = str()->random(10);

        $this->assertDatabaseMissing('users', [
            'github_id' => $githubId
        ]);

        $this->mockSocialiteCallback($githubId);

        $this->callbackRequest()
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'github_id' => $githubId
        ]);
    }

    public function test_authenticated_by_existing_user(): void
    {
        $githubId = str()->random(10);

        UserFactory::new()->create([
            'github_id' => $githubId
        ]);

        $this->assertDatabaseHas('users', [
            'github_id' => $githubId
        ]);

        $this->mockSocialiteCallback($githubId);

        $this->callbackRequest()
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();
    }

}
