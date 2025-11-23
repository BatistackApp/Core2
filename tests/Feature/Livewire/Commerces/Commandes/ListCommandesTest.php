<?php

use App\Livewire\Commerces\Commandes\ListCommandes;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ListCommandes::class)
        ->assertStatus(200);
});
