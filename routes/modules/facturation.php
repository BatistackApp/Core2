<?php

use Illuminate\Support\Facades\Route;

Route::prefix('facturation')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('facturation.index');
});