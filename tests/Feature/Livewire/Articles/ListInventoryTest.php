<?php

use App\Livewire\Articles\ListInventory;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ListInventory::class)
        ->assertStatus(200);
});
