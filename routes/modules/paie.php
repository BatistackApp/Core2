<?php

use Illuminate\Support\Facades\Route;

Route::prefix('paie')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('paie.index');
});