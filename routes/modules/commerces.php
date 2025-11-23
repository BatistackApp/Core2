<?php

use Illuminate\Support\Facades\Route;

Route::prefix('commerces')->group(function () {
    Route::get('/', \App\Livewire\Commerces\Dashboard::class)->name('commerces.index');

    Route::prefix('devis')->group(function () {
        Route::get('/', \App\Livewire\Commerces\Devis\ListeDevis::class)->name('commerces.devis.liste');
        Route::get('/{devis}', \App\Livewire\Commerces\Devis\ShowDevis::class)->name('commerces.devis.show');
    });

    Route::prefix('commandes')->group(function () {
        Route::get('/', \App\Livewire\Commerces\Commandes\ListCommandes::class )->name('commerces.commande.liste');
        Route::get('/{commande}', \App\Livewire\Commerces\Commandes\ShowCommandes::class)->name('commerces.commande.show');
    });
});
