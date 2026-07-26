<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\AccountDisabledException;
use App\Http\Controllers\Controller;
use App\Services\Auth\GoogleAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function callback(GoogleAuthService $googleAuthService): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = $googleAuthService->findOrCreateUser($googleUser);

            Auth::login($user, remember: true);
            request()->session()->regenerate();

            return redirect()->intended(route('dashboard', absolute: false));
        } catch (AccountDisabledException $exception) {
            return $this->authError($exception->getMessage());
        } catch (Throwable $exception) {
            Log::error('Google authentication failed.', [
                'message' => $exception->getMessage(),
                'exception' => $exception::class,
            ]);

            return $this->authError('Google authentication failed. Please try again.');
        }
    }

    private function authError(string $message): RedirectResponse
    {
        return redirect()
            ->route('auth.error')
            ->with('auth_error', $message);
    }
}
