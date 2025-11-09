
<?php

use App\Models\Core\Service;
use App\Models\User;
use App\Notifications\Core\BackupRestoreSuccessful;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Créer un utilisateur de test et l'authentifier
    $this->user = User::factory()->create();
    $this->actingAs($this->user);

    // Créer un service de test
    Service::factory()->create([
        'service_code' => 'TEST-001',
        'storage_limit' => 10, // 10 GB
    ]);

    // Fake le stockage
    Storage::fake('public');
});

describe('backupRestore', function () {
    test('restaure la sauvegarde avec succès', function () {
        Notification::fake();

        // Mock des commandes Artisan
        Artisan::shouldReceive('call')
            ->once()
            ->with('down')
            ->andReturn(0);

        Artisan::shouldReceive('call')
            ->once()
            ->with('backup:restore --no-interaction')
            ->andReturn(0);

        Artisan::shouldReceive('call')
            ->once()
            ->with('up')
            ->andReturn(0);

        // Créer plusieurs utilisateurs pour tester les notifications
        $users = User::factory()->count(3)->create();
        $users->push($this->user);

        $response = $this->getJson('/api/core/backup-restore');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Restauration effectuée avec succès',
            ]);

        // Vérifier que tous les utilisateurs ont reçu la notification
        Notification::assertSentTo(
            User::all(),
            BackupRestoreSuccessful::class
        );
    });

    test('retourne une erreur si la restauration échoue', function () {
        // Mock des commandes Artisan
        Artisan::shouldReceive('call')
            ->once()
            ->with('down')
            ->andReturn(0);

        Artisan::shouldReceive('call')
            ->once()
            ->with('backup:restore --no-interaction')
            ->andReturn(1); // Code d'erreur

        $response = $this->getJson('/api/core/backup-restore');

        $response->assertStatus(200);
    });
});

describe('storageInfo', function () {
    test('retourne les informations de stockage correctement', function () {
        // Créer des fichiers de test dans le dossier upload
        Storage::disk('public')->put('upload/file1.txt', 'content1'); // ~8 bytes
        Storage::disk('public')->put('upload/file2.txt', 'content2'); // ~8 bytes
        Storage::disk('public')->put('upload/subfolder/file3.txt', 'content3'); // ~8 bytes

        $response = $this->getJson('/api/core/storage/info');

        $response->assertStatus(200);

        $data = $response->json()[0];

        // Vérifier que les données de stockage sont présentes
        expect($data)->toHaveKeys([
            'storage_used',
            'storage_used_gb',
            'storage_used_mb',
            'storage_used_percentage',
        ])
            ->and($data['storage_used'])->toBeGreaterThan(0)
            ->and($data['storage_used_percentage'])->toBeGreaterThanOrEqual(0)
            ->and($data['storage_used_percentage'])->toBeLessThanOrEqual(100);

        // Vérifier que storage_used est supérieur à 0

        // Vérifier que le pourcentage est calculé correctement
    });

    test('retourne zéro si aucun fichier n\'existe', function () {
        // Aucun fichier créé dans le dossier upload

        $response = $this->getJson('/api/core/storage/info');

        $response->assertStatus(200);

        $data = $response->json()[0];

        expect($data['storage_used'])->toBe(0)
            ->and($data['storage_used_gb'])->toBe(0)
            ->and($data['storage_used_mb'])->toBe(0)
            ->and($data['storage_used_percentage'])->toBe(0);
    });

    test('calcule correctement le pourcentage de stockage utilisé', function () {
        $service = Service::first();
        $storageMax = $service->storage_limit * 1024 * 1024 * 1024; // 10 GB en bytes

        // Créer un fichier de taille connue (1 MB = 1048576 bytes)
        $fileSize = 1048576; // 1 MB
        Storage::disk('public')->put('upload/largefile.txt', str_repeat('a', $fileSize));

        $response = $this->getJson('/api/core/storage/info');

        $data = $response->json()[0];

        // Calculer le pourcentage attendu
        $expectedPercentage = round(($fileSize / $storageMax) * 100, 2);

        expect($data['storage_used'])->toBeGreaterThanOrEqual($fileSize)
            ->and($data['storage_used_mb'])->toBeGreaterThanOrEqual(1.0)
            ->and($data['storage_used_percentage'])->toBeGreaterThanOrEqual($expectedPercentage);
    });

    test('ignore les fichiers en dehors du dossier upload', function () {
        // Créer des fichiers dans et hors du dossier upload
        Storage::disk('public')->put('upload/file1.txt', 'content in upload');
        Storage::disk('public')->put('other/file2.txt', 'content outside upload');

        $response = $this->getJson('/api/core/storage/info');

        $data = $response->json()[0];

        // Le stockage devrait uniquement compter les fichiers dans upload
        $uploadFileSize = Storage::disk('public')->size('upload/file1.txt');

        expect($data['storage_used'])->toBe($uploadFileSize);
    });
});
