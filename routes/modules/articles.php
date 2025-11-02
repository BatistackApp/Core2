<?php

use Illuminate\Support\Facades\Route;

Route::prefix('articles')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('articles.index');
});