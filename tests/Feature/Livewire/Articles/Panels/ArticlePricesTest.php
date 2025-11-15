<?php

use App\Livewire\Articles\Panels\ArticlePrices;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ArticlePrices::class)
        ->assertStatus(200);
});
