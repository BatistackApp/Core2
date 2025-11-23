<?php

use App\Livewire\Commerces\Devis\ListeDevis;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ListeDevis::class)
        ->assertStatus(200);
});
