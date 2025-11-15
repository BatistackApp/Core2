<?php

use App\Enums\Tiers\TiersNature;
use App\Enums\Tiers\TiersType;
use App\Livewire\Tiers\Panels\TiersAddresses;
use App\Livewire\Tiers\Panels\TiersContacts;
use App\Livewire\Tiers\ShowTiers;
use App\Models\Comptabilite\PlanComptable;
use App\Models\Core\Bank;
use App\Models\Core\ConditionReglement;
use App\Models\Core\Country;
use App\Models\Core\ModeReglement;
use App\Models\Tiers\Tiers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

/**
 * Prépare un environnement de test complet avant chaque test.
 */
beforeEach(function () {
    // Crée un utilisateur et l'authentifie
    $this->user = User::factory()->create();
    actingAs($this->user);

    // Crée les données de base nécessaires pour les formulaires
    $this->planComptableGen = PlanComptable::factory()->create(['code' => '401000']);
    $this->planComptableAutre = PlanComptable::factory()->create(['code' => '411000']);
    $this->conditionReglement = ConditionReglement::factory()->create();
    $this->modeReglement = ModeReglement::factory()->create();
    $this->bank = Bank::factory()->create();
    $this->country = Country::factory()->create();

    // Crée un Tiers complet (CLIENT) avec toutes ses relations pour les tests
    $this->tiers = Tiers::factory()
        ->hasCustomerProfile(1, [
            'num_tva' => 'CLIENT_TVA_123',
            'code_comptable_general' => $this->planComptableGen->id,
            'code_comptable_client' => $this->planComptableAutre->id,
            'condition_reglement_id' => $this->conditionReglement->id,
            'mode_reglement_id' => $this->modeReglement->id,
        ])
        ->hasAddresses(1)
        ->hasContacts(1, ['civilite' => \App\Enums\Tiers\TiersCivility::MONSIEUR])
        ->hasBanks(1, ['bank_id' => $this->bank->id, 'default' => true])
        ->create([
            'name' => 'Tiers de Test Principal',
            'nature' => TiersNature::Client,
            'type' => TiersType::PMEPMI,
        ]);
});

test('la page de vue se charge et affiche les infos du tiers', function () {
    get(route('tiers.show', $this->tiers))
        ->assertOk()
        ->assertSeeLivewire(ShowTiers::class)
        ->assertSeeText($this->tiers->name) // Vérifie le nom dans le header
        ->assertSeeText($this->tiers->customerProfile->num_tva) // Vérifie une info de l'Infolist
        ->assertSeeText('Profil Client'); // Vérifie que la section conditionnelle s'affiche
});

test('la page de vue affiche les composants de relation', function () {
    get(route('tiers.show', $this->tiers))
        ->assertOk()
        ->assertSeeLivewire(TiersAddresses::class)
        ->assertSeeLivewire(TiersContacts::class)
        ->assertSeeLivewire(\App\Livewire\Tiers\Panels\TiersBank::class);
});
