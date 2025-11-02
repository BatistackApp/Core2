<?php

use Illuminate\Support\Facades\Route;

Route::prefix('rh')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('rh.index');
});