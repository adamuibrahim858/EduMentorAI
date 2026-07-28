<?php

namespace App\Livewire\Setting;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.setting.index', [
            'user' => auth()->user(),
        ]);
    }
}
