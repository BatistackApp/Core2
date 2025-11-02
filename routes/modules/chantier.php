<?php

use Illuminate\Support\Facades\Route;

Route::prefix('chantier')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('chantier.index');
});