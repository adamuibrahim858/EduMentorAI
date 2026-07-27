<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Signup extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|lowercase|email|max:255|unique:users,email')]
    public string $email = '';

    #[Validate('required|string|min:8|confirmed')]
    public string $password = '';

    public string $password_confirmation = '';

    #[Validate('accepted', message: 'You must accept the Terms and Privacy Policy to register.')]
    public bool $terms = false;

    public function signup(): void
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'status' => 'active',
        ]);

        event(new Registered($user));
        $user->sendEmailVerificationNotification();

        Auth::login($user);


        session()->regenerate();

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

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
