<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VerifyEmail extends Component
{
    public bool $verificationSent = false;

    public function sendVerificationNotification(): void
    {
        if (Auth::user()?->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        Auth::user()?->sendEmailVerificationNotification();

        $this->verificationSent = true;
    }

    public function logout(): void
    {
        Auth::guard('web')->logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirect(route('login'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.auth.verify-email')
            ->layout('layouts.guest', ['title' => 'Verify Email']);
    }
}
