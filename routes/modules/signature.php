<?php

use Illuminate\Support\Facades\Route;

Route::prefix('signature')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('signature.index');
});
