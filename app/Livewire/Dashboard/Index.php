<?php

namespace App\Livewire\Dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        return view('livewire.dashboard.index', [
            'user' => Auth::user(),
        ])->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
