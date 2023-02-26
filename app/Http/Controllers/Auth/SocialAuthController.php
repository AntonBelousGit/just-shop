<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialAuthController extends Controller
{
    /**
     * @param string $driver
     * @return RedirectResponse
     */
    public function redirect(string $driver): RedirectResponse
    {
        try {
            return Socialite::driver($driver)->redirect();
        }catch (Throwable $e){
            throw new DomainException('Произошла ошибка или драйвер не поддерживается');
        }

    }

    /**
     * @param string $driver
     * @return RedirectResponse
     */
    public function callback(string $driver): RedirectResponse
    {
        if ($driver !== 'github') {
            throw new DomainException('Драйвер не поддерживается');
        }
        $githubUser = Socialite::driver($driver)->user();

        $user = User::query()->updateOrCreate(
            [
                $driver . '_id' => $githubUser->id,
            ],
            [
                'name' => $githubUser->name,
                'email' => $githubUser->email,
                'password' => bcrypt(str()->random(20))
            ]
        );

        auth()->login($user);

        return redirect()->intended(route('home'));
    }
}
