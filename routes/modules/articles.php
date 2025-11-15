<?php

use Illuminate\Support\Facades\Route;

Route::prefix('articles')->group(function () {
    Route::get('/', \App\Livewire\Articles\ListArticles::class)->name('articles.index');
    Route::get('/{articles}', \App\Livewire\Articles\ShowArticles::class)->name('articles.show');
});
