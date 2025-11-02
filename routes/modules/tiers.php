<?php

use Illuminate\Support\Facades\Route;

Route::prefix('tiers')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('tiers.index');
});