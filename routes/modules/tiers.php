<?php

use Illuminate\Support\Facades\Route;

Route::prefix('tiers')->group(function () {
    Route::get('/', \App\Livewire\Tiers\ListTiers::class )->name('tiers.index');
});
