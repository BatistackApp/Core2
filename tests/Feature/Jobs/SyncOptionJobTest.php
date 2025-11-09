<?php

use App\Enums\Core\ServiceStatus;
use App\Jobs\Core\SyncOptionJob;
use App\Models\Core\Bank;
use App\Models\Core\Option;
use App\Models\Core\Service;
use App\Services\Batistack;
use App\Services\Bridge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Mockery\MockInterface;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Fake la queue pour tester les jobs
    Queue::fake();
});

it('synchronizes backup options', function () {
    // Préparer les données de test
    $service = Service::factory()->create([
        'status' => ServiceStatus::OK->value,
        'service_code' => 'TEST-SERVICE-CODE',
    ]);

    Option::factory()->create([
        'slug' => 'sauvegarde-et-retentions',
    ]);

    // Créer le mock
    $mockService = Mockery::mock(Batistack::class);
    $mockService->shouldReceive('post')
        ->once()
        ->with('/backup', ['license_key' => 'TEST-SERVICE-CODE'])
        ->andReturn(['success' => true]);

    // Injecter dans le conteneur
    $this->app->instance(Batistack::class, $mockService);

    // Mock de la commande Artisan
    Artisan::shouldReceive('call')
        ->once()
        ->with('backup:run', ['--only-db' => true]);

    // Exécuter le job
    $job = new SyncOptionJob('sauvegarde-et-retentions');
    $job->handle();

    // Vérifier que les expectations du mock sont satisfaites
    $mockService->shouldHaveReceived('post')->once();
});

describe('handle', function () {
    test('appelle la méthode correspondante selon le slug option', function () {
        $slugs = [
            'pack-signature',
            'extension-stockages',
        ];

        foreach ($slugs as $slug) {
            $job = new SyncOptionJob($slug);

            // Le job ne devrait pas lancer d'exception
            $job->handle();

            expect(true)->toBeTrue();
        }
    });

    test('ne fait rien pour un slug inconnu', function () {
        $job = new SyncOptionJob('unknown-slug');

        $job->handle();

        // Pas d'erreur attendue, le match retourne null
        expect(true)->toBeTrue();
    });
});

describe('syncPackSignature', function () {
    test('la méthode est appelée pour le slug pack-signature', function () {
        $job = new SyncOptionJob('pack-signature');

        // Pour l'instant cette méthode est vide, donc on vérifie juste qu'elle ne plante pas
        $job->handle();

        expect(true)->toBeTrue();
    });
});

describe('syncSauvegardeRetentions', function () {
    test('lance la sauvegarde si le service est OK et l\'option existe', function () {
        // Mock du service Batistack
        $this->mock(Batistack::class, function (MockInterface $mock) {
            $mock->shouldReceive('post')
                ->once()
                ->with('/backup', [
                    'license_key' => 'TEST-SERVICE-CODE',
                ])
                ->andReturn(['success' => true]);
        });

        // Mock de la commande Artisan
        Artisan::shouldReceive('call')
            ->once()
            ->with('backup:run', ['--only-db' => true])
            ->andReturn(0);

        Log::shouldReceive('info')
            ->with('Backup: Service OK')
            ->once();

        Log::shouldReceive('info')
            ->with('Backup: Option sauvegarde-et-retentions existe')
            ->once();

        // Créer le service avec le statut OK
        Service::create([
            'service_code' => 'TEST-SERVICE-CODE',
            'status' => ServiceStatus::OK->value,
            'max_user' => 10,
            'storage_limit' => 100,
        ]);

        // Créer l'option
        Option::create([
            'slug' => 'sauvegarde-et-retentions',
            'name' => 'Sauvegarde et Rétentions',
        ]);

        $job = new SyncOptionJob('sauvegarde-et-retentions');
        $job->handle();
    });

    test('ne lance pas la sauvegarde si le service n\'est pas OK', function () {
        Log::shouldReceive('info')->never();

        // Mock du service Batistack (ne devrait pas être appelé)
        $this->mock(Batistack::class, function (MockInterface $mock) {
            $mock->shouldReceive('post')->never();
        });

        // Créer le service avec un statut différent de OK
        Service::create([
            'service_code' => 'TEST-SERVICE-CODE',
            'status' => ServiceStatus::SUSPENDED->value,
            'max_user' => 10,
            'storage_limit' => 100,
        ]);

        // Créer l'option
        Option::create([
            'slug' => 'sauvegarde-et-retentions',
            'name' => 'Sauvegarde et Rétentions',
        ]);

        $job = new SyncOptionJob('sauvegarde-et-retentions');
        $job->handle();
    });

    test('ne lance pas la sauvegarde si l\'option n\'existe pas', function () {
        Log::shouldReceive('info')
            ->with('Backup: Service OK')
            ->once();

        // Mock du service Batistack (ne devrait pas être appelé)
        $this->mock(Batistack::class, function (MockInterface $mock) {
            $mock->shouldReceive('post')->never();
        });

        // Créer le service avec le statut OK
        Service::create([
            'service_code' => 'TEST-SERVICE-CODE',
            'status' => ServiceStatus::OK->value,
            'max_user' => 10,
            'storage_limit' => 100,
        ]);

        // Ne pas créer l'option

        $job = new SyncOptionJob('sauvegarde-et-retentions');
        $job->handle();
    });

    test('log une erreur en cas d\'exception', function () {
        // Mock du service Batistack qui lance une exception
        $this->mock(Batistack::class, function (MockInterface $mock) {
            $mock->shouldReceive('post')
                ->once()
                ->andThrow(new \Exception('Erreur de connexion'));
        });

        // Mock de la commande Artisan
        Artisan::shouldReceive('call')
            ->once()
            ->with('backup:run', ['--only-db' => true])
            ->andReturn(0);

        Log::shouldReceive('info')->twice();

        Log::shouldReceive('emergency')
            ->once()
            ->with('Backup: Erreur lors de la synchronisation de la sauvegarde et des retentions', \Mockery::type('array'));

        // Créer le service avec le statut OK
        Service::create([
            'service_code' => 'TEST-SERVICE-CODE',
            'status' => ServiceStatus::OK->value,
            'max_user' => 10,
            'storage_limit' => 100,
        ]);

        // Créer l'option
        Option::create([
            'slug' => 'sauvegarde-et-retentions',
            'name' => 'Sauvegarde et Rétentions',
        ]);

        $job = new SyncOptionJob('sauvegarde-et-retentions');
        $job->handle();
    });
});

describe('syncExtensionStockages', function () {
    test('la méthode est appelée pour le slug extension-stockages', function () {
        $job = new SyncOptionJob('extension-stockages');

        // Pour l'instant cette méthode est vide, donc on vérifie juste qu'elle ne plante pas
        $job->handle();

        expect(true)->toBeTrue();
    });
});

describe('syncAggregationBancaire', function () {
    test('importe les banques si aucune n\'existe', function () {
        // Mock du service Bridge
        $this->mock(Bridge::class, function (MockInterface $mock) {
            $mock->shouldReceive('get')
                ->once()
                ->with('/providers')
                ->andReturn([
                    'resources' => [
                        [
                            'id' => 1,
                            'name' => 'Banque Test 1',
                            'images' => ['logo' => 'https://example.com/logo1.png'],
                            'health_status' => [
                                'aggregation' => ['status' => 'healthy'],
                                'single_payment' => ['status' => 'healthy'],
                            ],
                        ],
                        [
                            'id' => 2,
                            'name' => 'Banque Test 2',
                            'images' => ['logo' => 'https://example.com/logo2.png'],
                            'health_status' => [
                                'aggregation' => ['status' => 'degraded'],
                                'single_payment' => ['status' => 'healthy'],
                            ],
                        ],
                    ],
                ]);
        });

        // Vérifier qu'aucune banque n'existe
        expect(Bank::count())->toBe(0);

        $job = new SyncOptionJob('aggregation-bancaire');
        $job->handle();

        // Vérifier que les banques ont été créées
        expect(Bank::count())->toBe(2);

        $this->assertDatabaseHas('banks', [
            'bridge_id' => 1,
            'name' => 'Banque Test 1',
            'logo_bank' => 'https://example.com/logo1.png',
            'status_aggregation' => 'healthy',
            'status_payment' => 'healthy',
        ]);

        $this->assertDatabaseHas('banks', [
            'bridge_id' => 2,
            'name' => 'Banque Test 2',
            'logo_bank' => 'https://example.com/logo2.png',
            'status_aggregation' => 'degraded',
            'status_payment' => 'healthy',
        ]);
    });

    test('n\'importe pas les banques si elles existent déjà', function () {
        // Créer une banque existante
        Bank::create([
            'bridge_id' => 999,
            'name' => 'Banque Existante',
            'logo_bank' => 'https://example.com/logo.png',
            'status_aggregation' => 'healthy',
            'status_payment' => 'healthy',
        ]);

        expect(Bank::count())->toBe(1);

        // Mock du service Bridge
        $this->mock(Bridge::class, function (MockInterface $mock) {
            $mock->shouldReceive('get')
                ->once()
                ->with('/providers')
                ->andReturn([
                    'resources' => [
                        [
                            'id' => 1,
                            'name' => 'Banque Test 1',
                            'images' => ['logo' => 'https://example.com/logo1.png'],
                            'health_status' => [
                                'aggregation' => ['status' => 'healthy'],
                                'single_payment' => ['status' => 'healthy'],
                            ],
                        ],
                    ],
                ]);
        });

        $job = new SyncOptionJob('aggregation-bancaire');
        $job->handle();

        // Vérifier qu'aucune nouvelle banque n'a été créée
        expect(Bank::count())->toBe(1);

        $this->assertDatabaseHas('banks', [
            'bridge_id' => 999,
            'name' => 'Banque Existante',
        ]);
    });

    test('gère correctement une liste vide de banques', function () {
        // Mock du service Bridge avec une réponse vide
        $this->mock(Bridge::class, function (MockInterface $mock) {
            $mock->shouldReceive('get')
                ->once()
                ->with('/providers')
                ->andReturn([
                    'resources' => [],
                ]);
        });

        expect(Bank::count())->toBe(0);

        $job = new SyncOptionJob('aggregation-bancaire');
        $job->handle();

        // Aucune banque ne devrait être créée
        expect(Bank::count())->toBe(0);
    });
});

describe('job configuration', function () {
    test('le job implémente ShouldQueue', function () {
        $job = new SyncOptionJob('test-slug');

        expect($job)->toBeInstanceOf(\Illuminate\Contracts\Queue\ShouldQueue::class);
    });

    test('le job peut être dispatché sur la queue', function () {
        Queue::fake();

        SyncOptionJob::dispatch('aggregation-bancaire', ['test' => 'value']);

        Queue::assertPushed(SyncOptionJob::class, function ($job) {
            return $job->slugOption === 'aggregation-bancaire'
                && $job->settings === ['test' => 'value'];
        });
    });

    test('le constructeur accepte un slug et des settings', function () {
        $settings = ['key1' => 'value1', 'key2' => 'value2'];
        $job = new SyncOptionJob('test-slug', $settings);

        expect($job->slugOption)->toBe('test-slug');
        expect($job->settings)->toBe($settings);
    });

    test('les settings sont optionnels dans le constructeur', function () {
        $job = new SyncOptionJob('test-slug');

        expect($job->slugOption)->toBe('test-slug');
        expect($job->settings)->toBe([]);
    });
});

describe('intégration des services', function () {
    test('utilise le service Batistack pour la sauvegarde', function () {
        $this->mock(Batistack::class, function (MockInterface $mock) {
            $mock->shouldReceive('post')
                ->once()
                ->with('/backup', \Mockery::type('array'))
                ->andReturn(['success' => true]);
        });

        Artisan::shouldReceive('call')->once()->andReturn(0);
        Log::shouldReceive('info')->twice();

        Service::create([
            'service_code' => 'TEST',
            'status' => ServiceStatus::OK->value,
            'max_user' => 10,
            'storage_limit' => 100,
        ]);

        Option::create([
            'slug' => 'sauvegarde-et-retentions',
            'name' => 'Sauvegarde et Rétentions',
        ]);

        $job = new SyncOptionJob('sauvegarde-et-retentions');
        $job->handle();
    });

    test('utilise le service Bridge pour l\'agrégation bancaire', function () {
        $this->mock(Bridge::class, function (MockInterface $mock) {
            $mock->shouldReceive('get')
                ->once()
                ->with('/providers')
                ->andReturn(['resources' => []]);
        });

        $job = new SyncOptionJob('aggregation-bancaire');
        $job->handle();
    });
});
