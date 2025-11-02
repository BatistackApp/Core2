<?php

use Illuminate\Support\Facades\Route;

Route::prefix('flotte')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('flotte.index');
});