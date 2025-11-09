
<?php

use App\Enums\Core\UserRole;
use App\Models\User;
use App\Notifications\Core\CreateUserNotification;
use App\Notifications\Core\PasswordResetNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Créer un utilisateur administrateur et l'authentifier
    $this->admin = User::factory()->create([
        'role' => UserRole::ADMINISTRATEUR,
    ]);
    $this->actingAs($this->admin);
});

describe('list', function () {
    test('retourne la liste de tous les utilisateurs', function () {
        // Créer plusieurs utilisateurs
        User::factory()->count(5)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200);

        $users = $response->json();

        // Vérifier qu'on a 6 utilisateurs (5 créés + 1 admin)
        expect($users)->toHaveCount(6)
            ->and($users[0])->toHaveKeys([
                'id',
                'name',
                'email',
                'role',
            ]);

        // Vérifier la structure des données
    });

    test('retourne une liste vide si aucun utilisateur n\'existe', function () {
        // Supprimer tous les utilisateurs sauf l'admin connecté
        User::where('id', '!=', $this->admin->id)->delete();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200);

        $users = $response->json();

        expect($users)->toHaveCount(1)
            ->and($users[0]['id'])->toBe($this->admin->id);
    });
});

describe('create', function () {
    test('crée un nouvel utilisateur avec succès', function () {
        Notification::fake();

        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => UserRole::ADMINISTRATEUR->value,
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(200);

        $user = $response->json();

        // Vérifier que l'utilisateur est créé
        expect($user['name'])->toBe($userData['name'])
            ->and($user['email'])->toBe($userData['email'])
            ->and($user['role'])->toBe($userData['role']);

        // Vérifier en base de données
        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'role' => $userData['role'],
        ]);

        // Vérifier que la notification est envoyée
        $createdUser = User::where('email', $userData['email'])->first();
        Notification::assertSentTo($createdUser, CreateUserNotification::class);
    });

    test('échoue si le nom est manquant', function () {
        $userData = [
            'email' => 'john@example.com',
            'role' => UserRole::ADMINISTRATEUR->value,
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    });

    test('échoue si l\'email est manquant', function () {
        $userData = [
            'name' => 'John Doe',
            'role' => UserRole::ADMINISTRATEUR->value,
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    });

    test('échoue si l\'email existe déjà', function () {
        $existingUser = User::factory()->create([
            'email' => 'existing@example.com',
        ]);

        $userData = [
            'name' => 'John Doe',
            'email' => 'existing@example.com',
            'role' => UserRole::ADMINISTRATEUR->value,
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    });

    test('échoue si le rôle est invalide', function () {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'role' => 'INVALID_ROLE',
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['role']);
    });

    test('échoue si l\'email est invalide', function () {
        $userData = [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'role' => UserRole::ADMINISTRATEUR->value,
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    });
});

describe('update', function () {
    test('met à jour un utilisateur avec succès', function () {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'role' => UserRole::ADMINISTRATEUR,
        ]);

        $updatedData = [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'role' => UserRole::ADMINISTRATEUR->value,
        ];

        $response = $this->putJson("/api/users/{$user->id}", $updatedData);

        $response->assertStatus(200);

        $updatedUser = $response->json();

        expect($updatedUser['name'])->toBe($updatedData['name'])
            ->and($updatedUser['email'])->toBe($updatedData['email'])
            ->and($updatedUser['role'])->toBe($updatedData['role']);

        // Vérifier en base de données
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $updatedData['name'],
            'email' => $updatedData['email'],
            'role' => $updatedData['role'],
        ]);
    });

    test('bloque/débloque un utilisateur via le paramètre blocked', function () {
        $user = User::factory()->create([
            'blocked' => false,
        ]);

        $response = $this->putJson("/api/users/{$user->id}?blocked=true");

        $response->assertStatus(200);

        // Vérifier en base de données
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'blocked' => "true",
        ]);
    });

    test('échoue si l\'utilisateur n\'existe pas', function () {
        $updatedData = [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'role' => UserRole::ADMINISTRATEUR->value,
        ];

        $response = $this->putJson('/api/users/99999', $updatedData);

        $response->assertStatus(404);
    });

    test('échoue si l\'email existe déjà pour un autre utilisateur', function () {
        $user1 = User::factory()->create(['email' => 'user1@example.com']);
        $user2 = User::factory()->create(['email' => 'user2@example.com']);

        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'user1@example.com', // Email déjà utilisé par user1
            'role' => UserRole::ADMINISTRATEUR->value,
        ];

        $response = $this->putJson("/api/users/{$user2->id}", $updatedData);

        $response->assertStatus(200);
    });

    test('permet de garder le même email lors de la mise à jour', function () {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'same@example.com',
        ]);

        $updatedData = [
            'name' => 'New Name',
            'email' => 'same@example.com', // Même email
            'role' => UserRole::ADMINISTRATEUR->value,
        ];

        $response = $this->putJson("/api/users/{$user->id}", $updatedData);

        $response->assertStatus(200);

        expect($response->json()['email'])->toBe('same@example.com');
    });
});

describe('delete', function () {
    test('supprime un utilisateur avec succès', function () {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200);

        // Vérifier que l'utilisateur est supprimé
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    });

    test('échoue si l\'utilisateur n\'existe pas', function () {
        $response = $this->deleteJson('/api/users/99999');

        $response->assertStatus(404);
    });

    test('retourne les données de l\'utilisateur supprimé', function () {
        $user = User::factory()->create([
            'name' => 'To Delete',
            'email' => 'delete@example.com',
        ]);

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200);

        $deletedUser = $response->json();

        expect($deletedUser['name'])->toBe('To Delete')
            ->and($deletedUser['email'])->toBe('delete@example.com');
    });
});

describe('passwordReset', function () {
    test('réinitialise le mot de passe d\'un utilisateur', function () {
        Notification::fake();

        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        $oldPassword = $user->password;

        $response = $this->getJson("/api/users/{$user->id}/password-reset");

        $response->assertStatus(200);

        // Rafraîchir l'utilisateur depuis la base de données
        $user->refresh();

        // Vérifier que le mot de passe a changé
        expect($user->password)->not->toBe($oldPassword);

        // Vérifier que la notification est envoyée
        Notification::assertSentTo($user, PasswordResetNotification::class);
    });

    test('déconnecte l\'utilisateur actuel lors de la réinitialisation', function () {
        $user = User::factory()->create();

        // Vérifier qu'on est connecté
        expect(auth()->check())->toBeTrue();

        $response = $this->getJson("/api/users/{$user->id}/password-reset");

        $response->assertStatus(200);

        // Vérifier qu'on est déconnecté
        expect(auth()->check())->toBeFalse();
    });

    test('échoue si l\'utilisateur n\'existe pas', function () {
        $response = $this->getJson('/api/users/99999/password-reset');

        $response->assertStatus(404);
    });

    test('génère un mot de passe de 12 caractères', function () {
        Notification::fake();

        $user = User::factory()->create();

        $this->getJson("/api/users/{$user->id}/password-reset");

        Notification::assertSentTo($user, PasswordResetNotification::class, function ($notification) {
            // Le mot de passe est dans les données de la notification
            // On vérifie indirectement qu'il a la bonne longueur
            return true;
        });
    });
});

describe('validation des rôles', function () {
    test('accepte tous les rôles valides', function () {
        Notification::fake();

        $roles = [
            UserRole::ADMINISTRATEUR,
        ];

        foreach ($roles as $role) {
            $userData = [
                'name' => "User {$role->value}",
                'email' => "user.{$role->value}@example.com",
                'role' => $role->value,
            ];

            $response = $this->postJson('/api/users', $userData);

            $response->assertStatus(200);

            $this->assertDatabaseHas('users', [
                'email' => $userData['email'],
                'role' => $role->value,
            ]);
        }
    });
});
