<?php

use Illuminate\Support\Facades\Route;

Route::prefix('articles')->group(function () {
    Route::get('/article', \App\Livewire\Articles\ListArticles::class)->name('articles.index');
    Route::get('/article/{articles}', \App\Livewire\Articles\ShowArticles::class)->name('articles.show');
    Route::get('/stocks', \App\Livewire\Articles\StockArticles::class)->name('articles.stock');
});
