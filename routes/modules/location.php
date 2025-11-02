<?php

use Illuminate\Support\Facades\Route;

Route::prefix('location')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('location.index');
});