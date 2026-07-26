<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Signup extends Component
{
    public function signUpWithGoogle()
    {
        return redirect()->route('auth.google.redirect');
    }

    public function render(): View
    {
        return view('livewire.auth.signup')
            ->layout('layouts.guest', ['title' => 'Sign Up']);
    }
}
