<?php

use App\Livewire\Tiers\ShowTiers;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ShowTiers::class)
        ->assertStatus(200);
});
