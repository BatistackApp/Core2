<?php

namespace Tests\Feature\Commands;

use App\Actions\Aggregation\User\AuthenticateUser;
use App\Actions\Aggregation\User\CreateUser;
use App\Jobs\Core\SyncOptionJob;
use App\Services\Batistack;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;

uses(RefreshDatabase::class);

/**
 * Prépare l'environnement de test avant chaque exécution.
 */
beforeEach(function () {
    // Simule les dépendances externes
    Storage::fake('public');
    Queue::fake();

    // Mock du service Batistack
    $this->batistackMock = $this->mock(Batistack::class, function (MockInterface $mock) {
        // La méthode get retournera les données de la licence valide
        $mock->shouldReceive('get')
            ->with('/license/info', ['license_key' => 'VALID-KEY'])
            ->andReturn(get_license_mock_data());

        // Et une réponse vide pour une clé invalide
        $mock->shouldReceive('get')
            ->with('/license/info', ['license_key' => 'INVALID-KEY'])
            ->andReturn([]);
    });

    // Mock des actions pour l'agrégation bancaire
    $this->mock(CreateUser::class, function (MockInterface $mock) {
        $mock->shouldReceive('get')->andReturn('mock-bridge-client-id');
    });
    $this->mock(AuthenticateUser::class, function (MockInterface $mock) {
        $mock->shouldReceive('get');
    });

    // Simule les appels HTTP pour les pays et les banques
    Http::fake([
        'https://gist.githubusercontent.com/*' => Http::response([
            ['code' => 'FR', 'name' => 'France'],
            ['code' => 'BE', 'name' => 'Belgique'],
        ], 200),
        '*/providers?*' => Http::response([
            'resources' => [
                [
                    'id' => 987,
                    'name' => 'Mock Bank',
                    'images' => ['logo' => 'http://example.com/logo.png'],
                    'health_status' => [
                        'aggregation' => ['status' => 'healthy'],
                        'single_payment' => ['status' => 'healthy'],
                    ],
                ],
            ],
        ], 200),
    ]);
});

/**
 * Teste que la commande échoue avec une clé de licence invalide.
 */
test('install command fails with an invalid license key', function () {
    $this->artisan('app:install', ['license_key' => 'INVALID-KEY'])
        ->expectsOutputToContain('License key invalide')
        ->assertExitCode(0); // La commande retourne 0 même en cas d'erreur

    // Vérifie qu'aucune donnée principale n'a été créée
    $this->assertDatabaseCount('services', 0);
    $this->assertDatabaseCount('modules', 0);
    $this->assertDatabaseCount('companies', 0);
});

/**
 * Teste le succès de l'installation avec une clé de licence valide.
 */
test('install command runs successfully with a valid license key', function () {
    // Exécute la commande et vérifie les sorties attendues
    $this->artisan('app:install', ['license_key' => 'VALID-KEY'])
        ->expectsOutputToContain('License key valide')
        ->expectsOutputToContain('Installation du service réussie')
        ->expectsOutputToContain('Installation des modules réussie')
        ->expectsOutputToContain('Installation des options réussie')
        ->expectsOutputToContain('Installation des informations de la société')
        ->expectsOutputToContain('Installation des conditions de réglement')
        ->expectsOutputToContain('Installation des modes de réglement')
        ->assertExitCode(0);

    $licenseData = get_license_mock_data();

    // Assertions sur la base de données
    $this->assertDatabaseHas('services', [
        'service_code' => $licenseData['service_code'],
        'status' => 'active',
        'max_user' => 10,
    ]);

    $this->assertDatabaseHas('modules', ['slug' => 'chantier', 'name' => 'Chantier']);
    $this->assertDatabaseHas('options', ['slug' => 'option-test', 'name' => 'Option Test']);
    $this->assertDatabaseHas('companies', ['name' => 'Mon Entreprise', 'email' => 'test@example.com']);
    $this->assertDatabaseHas('countries', ['name' => 'France']);
    $this->assertDatabaseHas('condition_reglements', ['code' => 'RECEP']);
    $this->assertDatabaseHas('mode_reglements', ['code' => 'CB']);

    // Assertions pour l'agrégation bancaire
    $this->assertDatabaseHas('banks', ['name' => 'Mock Bank']);
    $this->assertDatabaseHas('companies', ['bridge_client_id' => 'mock-bridge-client-id']);

    // Assertion sur le stockage
    Storage::disk('public')->assertExists('upload');

    // Assertion sur la file d'attente des jobs
    Queue::assertPushed(SyncOptionJob::class, function ($job) {
        return $job->slugOption === 'option-test';
    });
});


/**
 * Fournit des données de mock pour la réponse de l'API de licence.
 */
function get_license_mock_data(): array
{
    return [
        'id' => 123,
        'service_code' => 'SERVICE-001',
        'status' => 'active',
        'max_user' => 10,
        'storage_limit' => 5000,
        'product' => ['features' => []],
        'modules' => [
            [
                'feature' => [
                    'name' => 'Chantier',
                    'slug' => 'module-chantier',
                    'media' => 'http://example.com/chantier.png',
                    'description' => 'Module de gestion de chantiers',
                ],
                'is_active' => true,
            ],
        ],
        'options' => [
            [
                'product' => [
                    'name' => 'Option Test',
                    'slug' => 'option-test',
                    'media' => '/media/option.png',
                ],
                'settings' => ['key' => 'value'],
            ],
            [
                'product' => ['slug' => 'aggregation-bancaire'], // Pour déclencher l'import des banques
            ],
        ],
        'customer' => [
            'entreprise' => 'Mon Entreprise',
            'adresse' => '123 Rue du Test',
            'code_postal' => '75001',
            'ville' => 'Paris',
            'pays' => 'France',
            'tel' => '0123456789',
            'user' => ['email' => 'test@example.com'],
        ],
    ];
}
