<?php

use App\Livewire\Tiers\ListTiers;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ListTiers::class)
        ->assertStatus(200);
});
