<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.base')]
#[Title("Tableau de bord")]
class Home extends Component
{

    public function mount()
    {
        if (!auth()->check()) {
            abort(401);
        }
    }
    public function render()
    {
        return view('livewire.home');
    }
}
