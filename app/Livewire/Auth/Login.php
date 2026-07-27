<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();

        $throttleKey = Str::transliterate(Str::lower($this->email).'|'.request()->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        /** @var User|null $user */
        $user = User::where('email', $this->email)->first();

        if ($user && is_null($user->password)) {
            RateLimiter::hit($throttleKey);
            throw ValidationException::withMessages([
                'email' => 'This account was created with Google. Please log in using Google.',
            ]);
        }

        if ($user && $user->status !== 'active') {
            RateLimiter::hit($throttleKey);
            throw ValidationException::withMessages([
                'email' => 'Your account is currently disabled or suspended.',
            ]);
        }

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($throttleKey);
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($throttleKey);

        Auth::user()->forceFill([
            'last_login_at' => now(),
        ])->save();

        session()->regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false));
    }

    public function continueWithGoogle()
    {
        return redirect()->route('auth.google.redirect');
    }

    public function render(): View
    {
        return view('livewire.auth.login')
            ->layout('layouts.guest', ['title' => 'Login']);
    }
}
