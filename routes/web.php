<?php

use App\Livewire\Auth\Login;
use App\Livewire\Core\Config;
use App\Livewire\Core\Profil;
use App\Livewire\Home;
use App\Models\Core\Module;
use App\Services\Batistack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login');
Route::post('/logout', App\Livewire\Actions\Logout::class)
    ->name('logout');

Route::get('test', function () {
    dd(app(\App\Services\Bridge::class)->get('/payment/payment-account/beneficiaries', sector: 'payment'));
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', Home::class)->name('home');

    Route::get('/config', Config::class)->name('config.index');

    Route::get('profil', Profil::class)->name('profil');
    Route::get('license', \App\Livewire\Core\License::class)->name('license');

    Route::get('/module/redirect', function (Request $request) {
        $slug = $request->get('slug');
        return match($slug) {
            'chantier' => redirect()->route('chantier.index'),
            'tiers' => redirect()->route('tiers.index'),
            'articles' => redirect()->route('articles.index'),
            'commerces' => redirect()->route('commerces.index'),
            'facturation' => redirect()->route('facturation.index'),
            'banque' => redirect()->route('banque.index'),
            'comptabilite' => redirect()->route('comptabilite.index'),
            'location' => redirect()->route('location.index'),
            'rh' => redirect()->route('rh.index'),
            'paie' => redirect()->route('paie.index'),
            'planning' => redirect()->route('planning.index'),
            'ged' => redirect()->route('ged.index'),
            '3d-vision' => redirect()->route('3d-vision.index'),
            'flotte' => redirect()->route('flotte.index'),
            'notes-frais' => redirect()->route('notes-frais.index'),
            'signature' => redirect()->route('signature.index'),
            default => redirect()->route('home'),
        };
    })->name('module.redirect');

    include('modules/chantier.php');
    include('modules/tiers.php');
    include('modules/articles.php');
    include('modules/commerces.php');
    include('modules/facturation.php');
    include('modules/banque.php');
    include('modules/comptabilite.php');
    include('modules/location.php');
    include('modules/rh.php');
    include('modules/paie.php');
    include('modules/planning.php');
    include('modules/ged.php');
    include('modules/3d-vision.php');
    include('modules/flotte.php');
    include('modules/notes-frais.php');
});
