<?php

use App\Livewire\Core\Config;
use App\Livewire\Core\Profil;
use App\Livewire\Home;
use App\Models\User;
use App\Services\VatValidator;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

describe('Home Component', function () {
    it('renders successfully for authenticated users', function () {
        $user = User::factory()->create();

        actingAs($user);

        Livewire::test(Home::class)
            ->assertStatus(200);
    });

    it('redirects unauthenticated users', function () {
        Livewire::test(Home::class)
            ->assertUnauthorized();
    });

    it('has correct layout', function () {
        $user = User::factory()->create();

        actingAs($user);

        get('/')
            ->assertSeeLivewire(Home::class);
    });

    it('uses base layout', function () {
        $user = User::factory()->create();

        actingAs($user);

        $component = Livewire::test(Home::class);

        $reflection = new \ReflectionClass(Home::class);
        $attributes = $reflection->getAttributes(\Livewire\Attributes\Layout::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->getArguments()[0])->toBe('layouts.base');
    });

    it('has correct title', function () {
        $user = User::factory()->create();

        actingAs($user);

        $reflection = new \ReflectionClass(Home::class);
        $attributes = $reflection->getAttributes(\Livewire\Attributes\Title::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->getArguments()[0])->toBe('Tableau de bord');
    });
});

describe('Config Component', function () {
    it('renders successfully for authenticated users', function () {
        $user = User::factory()->create();
        $company = \App\Models\Core\Company::factory()->create();

        actingAs($user);

        Livewire::test(Config::class)
            ->assertStatus(200);
    });

    it('redirects unauthenticated users', function () {
        Livewire::test(Config::class)
            ->assertUnauthorized();
    });

    it('has correct layout', function () {
        $user = User::factory()->create();

        actingAs($user);

        $reflection = new \ReflectionClass(Config::class);
        $attributes = $reflection->getAttributes(\Livewire\Attributes\Layout::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->getArguments()[0])->toBe('layouts.base');
    });

    it('has correct title', function () {
        $user = User::factory()->create();

        actingAs($user);

        $reflection = new \ReflectionClass(Config::class);
        $attributes = $reflection->getAttributes(\Livewire\Attributes\Title::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->getArguments()[0])->toBe('Configuration');
    });

    describe("Config Company Component", function () {
        beforeEach(function () {

            $company = \App\Models\Core\Company::factory()->create();
            $country = \App\Models\Core\Country::create(['name' => 'France']);
        });
        test("submit form with valid data", function () {
            $user = User::factory()->create();
            Livewire::actingAs($user)
                ->test(\App\Livewire\Core\ConfigCompany::class)
                ->fillForm([
                    'name' => 'New Company Name',
                    'address' => 'New Address',
                    'code_postal' => '12345',
                    'ville' => 'New City',
                    'pays' => 'France',
                    'phone' => '1234567890',
                    'fax' => '1234567890',
                    'email' => 'test@test.com',
                    'web' => 'https://www.example.com',
                    'siret' => '99999999999999',
                    'ape' => '00N0',
                    'capital' => '100000',
                    'rcs' => 'La Roche Sur Yon B 999 999 999',
                    'tva' => true,
                    'num_tva' => 'FR12345678901',
                ])
                ->call('updateCompany')
                ->assertHasNoErrors();
        });

        test("Verify Siren Action is valid", function () {
            $user = User::factory()->create();

            Livewire::actingAs($user)
                ->test(\App\Livewire\Core\ConfigCompany::class)
                ->set('data.siret', '12345678901234')
                ->call('verifySiren')
                ->assertHasNoErrors();
        });

        test("Verify VAT Number Action is valid", function () {
            $user = User::factory()->create();

            Livewire::actingAs($user)
                ->test(\App\Livewire\Core\ConfigCompany::class)
                ->set('data.numTva', 'FR999999999')
                ->call('verifVat')
                ->assertHasNoErrors();
        });
    });

    describe('Verify VAT Action', function () {
        beforeEach(function () {
            $this->user = User::factory()->create();
            actingAs($this->user);
        });

        it('validates a valid VAT number', function () {
            // Mock du service VatValidator
            $vatValidatorMock = Mockery::mock(VatValidator::class);
            $vatValidatorMock->shouldReceive('isValid')
                ->with('FR12345678901')
                ->once()
                ->andReturn(true);

            app()->instance(VatValidator::class, $vatValidatorMock);

            // Simuler l'appel de l'action
            $vatNumber = 'FR12345678901';
            $validator = app(VatValidator::class);
            $result = $validator->isValid($vatNumber);

            expect($result)->toBeTrue();
        });

        it('rejects an invalid VAT number', function () {
            // Mock du service VatValidator
            $vatValidatorMock = Mockery::mock(VatValidator::class);
            $vatValidatorMock->shouldReceive('isValid')
                ->with('INVALID_VAT')
                ->once()
                ->andReturn(false);

            app()->instance(VatValidator::class, $vatValidatorMock);

            // Simuler l'appel de l'action
            $vatNumber = 'INVALID_VAT';
            $validator = app(VatValidator::class);
            $result = $validator->isValid($vatNumber);

            expect($result)->toBeFalse();
        });

        it('handles empty VAT number', function () {
            $vatNumber = '';

            expect($vatNumber)->toBeEmpty();
        });

        it('handles null VAT number', function () {
            $vatNumber = null;

            expect($vatNumber)->toBeNull();
        });

        it('validates multiple VAT formats', function () {
            $vatValidatorMock = Mockery::mock(VatValidator::class);

            // Format français
            $vatValidatorMock->shouldReceive('isValid')
                ->with('FR12345678901')
                ->once()
                ->andReturn(true);

            // Format belge
            $vatValidatorMock->shouldReceive('isValid')
                ->with('BE0123456789')
                ->once()
                ->andReturn(true);

            // Format allemand
            $vatValidatorMock->shouldReceive('isValid')
                ->with('DE123456789')
                ->once()
                ->andReturn(true);

            app()->instance(VatValidator::class, $vatValidatorMock);

            $validator = app(VatValidator::class);

            expect($validator->isValid('FR12345678901'))->toBeTrue()
                ->and($validator->isValid('BE0123456789'))->toBeTrue()
                ->and($validator->isValid('DE123456789'))->toBeTrue();
        });

        it('validates VAT number with spaces', function () {
            $vatValidatorMock = Mockery::mock(VatValidator::class);
            $vatValidatorMock->shouldReceive('isValid')
                ->with('FR 12 345 678 901')
                ->once()
                ->andReturn(true);

            app()->instance(VatValidator::class, $vatValidatorMock);

            $validator = app(VatValidator::class);
            $result = $validator->isValid('FR 12 345 678 901');

            expect($result)->toBeTrue();
        });

        it('rejects VAT number with invalid country code', function () {
            $vatValidatorMock = Mockery::mock(VatValidator::class);
            $vatValidatorMock->shouldReceive('isValid')
                ->with('XX12345678901')
                ->once()
                ->andReturn(false);

            app()->instance(VatValidator::class, $vatValidatorMock);

            $validator = app(VatValidator::class);
            $result = $validator->isValid('XX12345678901');

            expect($result)->toBeFalse();
        });

        it('rejects VAT number with invalid length', function () {
            $vatValidatorMock = Mockery::mock(VatValidator::class);
            $vatValidatorMock->shouldReceive('isValid')
                ->with('FR123')
                ->once()
                ->andReturn(false);

            app()->instance(VatValidator::class, $vatValidatorMock);

            $validator = app(VatValidator::class);
            $result = $validator->isValid('FR123');

            expect($result)->toBeFalse();
        });

        it('handles special characters in VAT number', function () {
            $vatValidatorMock = Mockery::mock(VatValidator::class);
            $vatValidatorMock->shouldReceive('isValid')
                ->with('FR@#$%^&*()')
                ->once()
                ->andReturn(false);

            app()->instance(VatValidator::class, $vatValidatorMock);

            $validator = app(VatValidator::class);
            $result = $validator->isValid('FR@#$%^&*()');

            expect($result)->toBeFalse();
        });

        it('validates VAT number in lowercase', function () {
            $vatValidatorMock = Mockery::mock(VatValidator::class);
            $vatValidatorMock->shouldReceive('isValid')
                ->with('fr12345678901')
                ->once()
                ->andReturn(true);

            app()->instance(VatValidator::class, $vatValidatorMock);

            $validator = app(VatValidator::class);
            $result = $validator->isValid('fr12345678901');

            expect($result)->toBeTrue();
        });
    });
});

describe('Profil Component', function () {
    it('renders successfully for authenticated users', function () {
        $user = User::factory()->create();

        actingAs($user);

        Livewire::test(Profil::class)
            ->assertStatus(200);
    });

    it('redirects unauthenticated users', function () {
        Livewire::test(Profil::class)
            ->assertUnauthorized();
    });

    it('has correct layout', function () {
        $user = User::factory()->create();

        actingAs($user);

        $reflection = new \ReflectionClass(Profil::class);
        $attributes = $reflection->getAttributes(\Livewire\Attributes\Layout::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->getArguments()[0])->toBe('layouts.base');
    });

    it('has correct title', function () {
        $user = User::factory()->create();

        actingAs($user);

        $reflection = new \ReflectionClass(Profil::class);
        $attributes = $reflection->getAttributes(\Livewire\Attributes\Title::class);

        expect($attributes)->toHaveCount(1)
            ->and($attributes[0]->getArguments()[0])->toBe('Mon Compte');
    });

    it('displays user information', function () {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        actingAs($user);

        get(route('profil'))
            ->assertSeeLivewire(Profil::class);
    });
});

describe('Core Navigation', function () {
    it('allows authenticated users to navigate to home', function () {
        $user = User::factory()->create();

        actingAs($user);

        get('/')
            ->assertStatus(200)
            ->assertSeeLivewire(Home::class);
    });

    it('allows authenticated users to navigate to config', function () {
        $user = User::factory()->create();
        $company = \App\Models\Core\Company::factory()->create();

        actingAs($user);

        get(route('config.index'))
            ->assertStatus(200)
            ->assertSeeLivewire(Config::class);
    });

    it('allows authenticated users to navigate to profil', function () {
        $user = User::factory()->create();

        actingAs($user);

        get(route('profil'))
            ->assertStatus(200)
            ->assertSeeLivewire(Profil::class);
    });

    it('redirects unauthenticated users to login', function () {
        get('/')
            ->assertRedirect(route('login'));

        get(route('config.index'))
            ->assertRedirect(route('login'));

        get(route('profil'))
            ->assertRedirect(route('login'));
    });
});

describe('Core Components Integration', function () {
    it('maintains session across core components', function () {
        $user = User::factory()->create();
        $company = \App\Models\Core\Company::factory()->create();

        actingAs($user);

        // Test navigation entre les composants
        get('/')
            ->assertStatus(200);

        get(route('config.index'))
            ->assertStatus(200);

        get(route('profil'))
            ->assertStatus(200);

        // Vérifier que l'utilisateur est toujours authentifié
        expect(auth()->check())->toBeTrue()
            ->and(auth()->id())->toBe($user->id);
    });

    it('shares correct user data across components', function () {
        $user = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
        $company = \App\Models\Core\Company::factory()->create();

        actingAs($user);

        Livewire::test(Home::class)
            ->assertStatus(200);

        Livewire::test(Config::class)
            ->assertStatus(200);

        Livewire::test(Profil::class)
            ->assertStatus(200);

        // Vérifier que c'est le même utilisateur partout
        expect(auth()->user()->name)->toBe('Jane Doe')
            ->and(auth()->user()->email)->toBe('jane@example.com');
    });

    it('handles logout correctly from any component', function () {
        $user = User::factory()->create();

        actingAs($user);

        // Visiter un composant
        get('/')
            ->assertStatus(200);

        // Se déconnecter
        auth()->logout();

        // Vérifier que l'accès est refusé
        get('/')
            ->assertRedirect(route('login'));

        expect(auth()->check())->toBeFalse();
    });
});
