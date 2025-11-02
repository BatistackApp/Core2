<?php

use Illuminate\Support\Facades\Route;

Route::prefix('planning')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('planning.index');
});