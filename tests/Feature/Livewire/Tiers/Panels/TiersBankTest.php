<?php

use App\Livewire\Tiers\Panels\TiersBank;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(TiersBank::class)
        ->assertStatus(200);
});
