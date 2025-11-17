<?php

use App\Livewire\Articles\Panels\ArticleStock;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(ArticleStock::class)
        ->assertStatus(200);
});
