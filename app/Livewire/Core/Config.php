<?php

namespace App\Livewire\Core;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.base')]
#[Title('Configuration')]


class Config extends Component
{
    public function mount()
    {
        if (!auth()->check()) {
            abort(401);
        }
    }
    public function render()
    {
        return view('livewire.core.config');
    }
}
