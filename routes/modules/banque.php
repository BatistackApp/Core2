<?php

use Illuminate\Support\Facades\Route;

Route::prefix('banque')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('banque.index');
});