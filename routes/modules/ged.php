<?php

use Illuminate\Support\Facades\Route;

Route::prefix('ged')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('ged.index');
});