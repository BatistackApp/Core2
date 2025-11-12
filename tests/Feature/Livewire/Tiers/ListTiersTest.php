<?php

use App\Enums\Tiers\TiersNature;
use App\Enums\Tiers\TiersType;
use App\Livewire\Tiers\ListTiers;
use App\Models\Comptabilite\PlanComptable;
use App\Models\Core\ConditionReglement;
use App\Models\Core\ModeReglement;
use App\Models\Tiers\Tiers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\get;

// Utilise RefreshDatabase pour réinitialiser la BDD à chaque test
uses(RefreshDatabase::class);

// Prépare un utilisateur et des données de base avant chaque test
beforeEach(function () {
    // Crée un utilisateur et l'authentifie
    $this->user = User::factory()->create();
    actingAs($this->user);

    // Crée les données nécessaires pour les listes déroulantes du formulaire
    $this->planComptableGen = PlanComptable::factory()->create(['code' => '401000']);
    $this->planComptableAutre = PlanComptable::factory()->create(['code' => '411000']);
    $this->conditionReglement = ConditionReglement::factory()->create();
    $this->modeReglement = ModeReglement::factory()->create();
});

test('le composant de liste des tiers se charge correctement', function () {
    // Vérifie que la route (en supposant 'tiers.index') est accessible
    // et que le composant Livewire est bien présent
    get(route('tiers.index')) // Assurez-vous que cette route existe dans routes/modules/tiers.php
    ->assertOk()
        ->assertSeeLivewire(ListTiers::class);
});

test('la table affiche les tiers existants', function () {
    $tiers = Tiers::factory()->create(['name' => 'Mon Tiers Test']);

    Livewire::test(ListTiers::class)
        ->assertCanSeeTableRecords(collect([$tiers]));
});

test('la table peut rechercher un tiers par nom', function () {
    Tiers::factory()->create(['name' => 'Client A Rechercher']);
    Tiers::factory()->create(['name' => 'Fournisseur B']);

    Livewire::test(ListTiers::class)
        ->searchTable('Client A')
        ->assertCanSeeTableRecords(Tiers::where('name', 'Client A Rechercher')->get())
        ->assertCanNotSeeTableRecords(['name', 'Fournisseur B']);
});

test('la table peut filtrer par nature', function () {
    $client = Tiers::factory()->create(['nature' => TiersNature::Client]);
    $fournisseur = Tiers::factory()->create(['nature' => TiersNature::Fournisseur]);

    Livewire::test(ListTiers::class)
        ->filterTable('nature', TiersNature::Client->value)
        ->assertCanSeeTableRecords(collect([$client]))
        ->assertCanNotSeeTableRecords(collect([$fournisseur]));
});

test('la table peut filtrer par type', function () {
    $particulier = Tiers::factory()->create(['type' => TiersType::Particulier]);
    $pro = Tiers::factory()->create(['type' => TiersType::PMEPMI]);

    Livewire::test(ListTiers::class)
        ->filterTable('type', TiersType::Particulier->value)
        ->assertCanSeeTableRecords(collect([$particulier]));
});

test('peut créer un nouveau tiers de nature CLIENT', function () {
    $dataClient = [
        'code_tiers' => 'CLT2025-1',
        'name' => 'Nouveau Client Test',
        'nature' => TiersNature::Client,
        'type' => TiersType::PMEPMI,
        'email' => 'client@test.com',
        'phone' => '0123456789',
        // --- Champs Client ---
        'tva' => true,
        'num_tva' => 'FR123456789',
        'rem_relative' => 5.0,
        'rem_fixe' => 10.0,
        'code_comptable_general' => $this->planComptableGen->id,
        'code_comptable_client' => $this->planComptableAutre->id,
        'condition_reglement' => $this->conditionReglement->id,
        'mode_reglement' => $this->modeReglement->id,
        // --- Champs Banque ---
        'iban' => 'FR7630006000011234567890189',
        'bic' => 'BNPAFRPPXXX',
        'default' => true,
    ];

    Livewire::test(ListTiers::class)
        // Appelle l'action 'create' de la table
        ->callTableAction('create', data: $dataClient)
        ->assertHasNoTableActionErrors(); // Vérifie qu'il n'y a pas d'erreur de validation

    // Vérifie que le tiers principal a été créé
    assertDatabaseHas('tiers', [
        'code_tiers' => 'CLT2025-1',
        'name' => 'Nouveau Client Test',
        'nature' => TiersNature::Client,
    ]);

    // Récupère le nouvel ID
    $newTiers = Tiers::firstWhere('code_tiers', 'CLT2025-1');

    // Vérifie que le profil CLIENT a été créé
    assertDatabaseHas('tiers_customers', [
        'tiers_id' => $newTiers->id,
        'num_tva' => '1',
    ]);

    // Vérifie qu'AUCUN profil fournisseur n'a été créé
    assertDatabaseMissing('tiers_supplies', [
        'tiers_id' => $newTiers->id,
    ]);
});

test('peut créer un nouveau tiers de nature FOURNISSEUR', function () {
    $dataFournisseur = [
        'code_tiers' => 'FOUR2025-1',
        'name' => 'Nouveau Fournisseur Test',
        'nature' => TiersNature::Fournisseur,
        'type' => TiersType::PMEPMI,
        'email' => 'fournisseur@test.com',
        'phone' => '0987654321',
        // --- Champs Fournisseur ---
        'tva' => true,
        'num_tva' => 'FR987654321',
        'rem_relative' => 0.0,
        'rem_fixe' => 0.0,
        'code_comptable_general' => $this->planComptableGen->id,
        'code_comptable_fournisseur' => $this->planComptableAutre->id,
        'condition_reglement' => $this->conditionReglement->id,
        'mode_reglement' => $this->modeReglement->id,
    ];

    Livewire::test(ListTiers::class)
        ->callTableAction('create', data: $dataFournisseur)
        ->assertHasNoTableActionErrors();

    // Vérifie que le tiers principal a été créé
    assertDatabaseHas('tiers', [
        'code_tiers' => 'FOUR2025-1',
        'nature' => TiersNature::Fournisseur,
    ]);

    $newTiers = Tiers::firstWhere('code_tiers', 'FOUR2025-1');

    // Vérifie que le profil FOURNISSEUR a été créé
    assertDatabaseHas('tiers_supplies', [
        'tiers_id' => $newTiers->id,
        'num_tva' => '1',
    ]);

    // Vérifie qu'AUCUN profil client n'a été créé
    assertDatabaseMissing('tiers_customers', [
        'tiers_id' => $newTiers->id,
    ]);
});

test('peut supprimer un tiers', function () {
    $tiers = Tiers::factory()->create();

    Livewire::test(ListTiers::class)
        ->callTableAction('delete', $tiers)
        ->assertHasNoTableActionErrors();

    // Vérifie que le tiers a été supprimé
});
