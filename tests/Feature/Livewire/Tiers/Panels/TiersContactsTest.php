<?php

use App\Livewire\Tiers\Panels\TiersContacts;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(TiersContacts::class)
        ->assertStatus(200);
});
