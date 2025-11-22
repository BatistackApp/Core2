<?php

use App\Livewire\Articles\ShowInventory;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ShowInventory::class)
        ->assertStatus(200);
});
