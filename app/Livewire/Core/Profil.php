<?php

namespace App\Livewire\Core;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.base')]
#[Title('Mon Compte')]
class Profil extends Component
{
    public function render()
    {
        return view('livewire.core.profil');
    }
}
