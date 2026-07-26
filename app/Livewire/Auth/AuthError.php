<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class AuthError extends Component
{
    public string $message;

    public function mount(): void
    {
        $this->message = session('auth_error', 'Something went wrong while signing you in. Please try again.');
    }

    public function render(): View
    {
        return view('livewire.auth.auth-error')
            ->layout('layouts.guest', ['title' => 'Authentication Error']);
    }
}
