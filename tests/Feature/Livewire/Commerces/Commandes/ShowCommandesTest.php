<?php

use App\Livewire\Commerces\Commandes\ShowCommandes;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ShowCommandes::class)
        ->assertStatus(200);
});
