<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

dataset('authenticated_routes', [
    'home' => ['home'],
]);

test('authenticated user can access main routes', function (string $routeName) {
    $this->actingAs(User::factory()->create());

    $response = $this->get(route($routeName));

    $response->assertStatus(200);
})->with('authenticated_routes');


test('module redirection works for existing slugs', function() {
    $this->actingAs(User::factory()->create());

    // Nous testons une des redirections définies dans votre fichier web.php
    $response = $this->get(route('module.redirect', ['slug' => 'chantier']));

    // Cela suppose que la route 'chantier.index' est bien définie dans 'routes/modules/chantier.php'.
    // Comme il s'agit d'une redirection, nous vérifions le code de statut de redirection.
    $response->assertRedirect(route('chantier.index'));
});

test('module redirection redirects to home for unknown slugs', function() {
    $this->actingAs(User::factory()->create());

    $response = $this->get(route('module.redirect', ['slug' => 'non-existent-slug']));

    $response->assertRedirect(route('home'));
});


test('guests are redirected from authenticated routes to login', function(string $routeName) {
    // Ici, nous n'authentifions pas d'utilisateur
    $response = $this->get(route($routeName));

    $response->assertRedirect(route('login'));
})->with('authenticated_routes');


test('guests can access login page', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
});
