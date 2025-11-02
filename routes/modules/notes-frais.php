<?php

use Illuminate\Support\Facades\Route;

Route::prefix('notes-frais')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('notes-frais.index');
});