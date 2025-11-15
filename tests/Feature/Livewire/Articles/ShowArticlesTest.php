<?php

use App\Livewire\Articles\ShowArticles;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ShowArticles::class)
        ->assertStatus(200);
});
