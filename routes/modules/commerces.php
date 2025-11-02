<?php

use Illuminate\Support\Facades\Route;

Route::prefix('commerces')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('commerces.index');
});