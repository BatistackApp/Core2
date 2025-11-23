<?php

use App\Livewire\Articles\StockArticles;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(StockArticles::class)
        ->assertStatus(200);
});
