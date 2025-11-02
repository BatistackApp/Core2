<?php

use Illuminate\Support\Facades\Route;

Route::prefix('3d-vision')->group(function () {
    Route::get('/', function () {
        dd('OK');
    })->name('3d-vision.index');
});