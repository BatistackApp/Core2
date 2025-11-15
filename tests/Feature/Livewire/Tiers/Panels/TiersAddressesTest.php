<?php

use App\Livewire\Tiers\Panels\TiersAddresses;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(TiersAddresses::class)
        ->assertStatus(200);
});
