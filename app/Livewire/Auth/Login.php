<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Login extends Component
{
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
