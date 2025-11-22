<?php

use Illuminate\Support\Facades\Route;

Route::prefix('articles')->group(function () {
    Route::get('/article', \App\Livewire\Articles\ListArticles::class)->name('articles.index');
    Route::get('/article/{articles}', \App\Livewire\Articles\ShowArticles::class)->name('articles.show');
    Route::get('/stocks', \App\Livewire\Articles\StockArticles::class)->name('articles.stock');
    Route::get('/inventory', \App\Livewire\Articles\ListInventory::class)->name('articles.inventory');
    Route::get('/inventory/{inventory}', \App\Livewire\Articles\ShowInventory::class)->name('articles.inventory.show');
});
