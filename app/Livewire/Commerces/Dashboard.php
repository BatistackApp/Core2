<?php

namespace App\Livewire\Commerces;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.base')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.commerces.dashboard');
    }
}
