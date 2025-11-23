<?php

use App\Livewire\Commerces\Devis\ShowDevis;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ShowDevis::class)
        ->assertStatus(200);
});
