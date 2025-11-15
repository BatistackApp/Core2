<?php

use App\Livewire\Articles\ListArticles;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ListArticles::class)
        ->assertStatus(200);
});
