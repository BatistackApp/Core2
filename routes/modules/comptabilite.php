<?php

use Illuminate\Support\Facades\Route;

Route::prefix('comptabilite')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('comptabilite.index');
});