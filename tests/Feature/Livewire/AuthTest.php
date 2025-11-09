<?php

use App\Livewire\Auth\ConfirmPassword;
use App\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Laravel\Fortify\Features;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

describe('Login Component', function () {
    beforeEach(function () {
        RateLimiter::clear('login-test');
    });

    it('renders successfully', function () {
        Livewire::test(Login::class)
            ->assertStatus(200);
    });

    it('has form fields', function () {
        Livewire::test(Login::class)
            ->assertFormExists()
            ->assertFormFieldExists('email')
            ->assertFormFieldExists('password')
            ->assertFormFieldExists('remember');
    });

    it('validates required fields', function () {
        Livewire::test(Login::class)
            ->call('login')
            ->assertHasFormErrors(['email' => 'required', 'password' => 'required']);
    });

    it('logs in user with valid credentials', function () {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        Livewire::test(Login::class)
            ->fillForm([
                'email' => 'test@example.com',
                'password' => 'password123',
                'remember' => false,
            ])
            ->call('login')
            ->assertRedirect('/');

        expect(Auth::check())->toBeTrue()
            ->and(Auth::user()->id)->toBe($user->id);
    });

    it('logs in user with remember me option', function () {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        Livewire::test(Login::class)
            ->fillForm([
                'email' => 'test@example.com',
                'password' => 'password123',
                'remember' => true,
            ])
            ->call('login')
            ->assertRedirect('/');

        expect(Auth::check())->toBeTrue()
            ->and(Auth::user()->id)->toBe($user->id);

        // Vérifier que le cookie "remember me" a été défini
        $rememberToken = $user->fresh()->remember_token;
        expect($rememberToken)->not->toBeNull();
    });

    it('fails login with invalid credentials', function () {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        Livewire::test(Login::class)
            ->fillForm([
                'email' => 'test@example.com',
                'password' => 'wrong-password',
                'remember' => false,
            ])
            ->call('login')
            ->assertHasFormErrors(['email']);

        expect(Auth::check())->toBeFalse();
    });

    it('fails login with non-existent user', function () {
        Livewire::test(Login::class)
            ->fillForm([
                'email' => 'nonexistent@example.com',
                'password' => 'password123',
                'remember' => false,
            ])
            ->call('login')
            ->assertHasFormErrors(['email']);

        expect(Auth::check())->toBeFalse();
    });

    it('rate limits login attempts after 5 failed attempts', function () {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Effectuer 5 tentatives échouées
        for ($i = 0; $i < 5; $i++) {
            try {
                Livewire::test(Login::class)
                    ->fillForm([
                        'email' => 'test@example.com',
                        'password' => 'wrong-password',
                        'remember' => false,
                    ])
                    ->call('login');
            } catch (\Exception $e) {
                // Ignorer les exceptions de validation
            }
        }

        // La 6ème tentative devrait être rate-limitée
        Event::fake();

        Livewire::test(Login::class)
            ->fillForm([
                'email' => 'test@example.com',
                'password' => 'password123',
                'remember' => false,
            ])
            ->call('login')
            ->assertHasFormErrors(['email']);

        Event::assertDispatched(Lockout::class);
    });

    it('clears rate limiter on successful login', function () {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Effectuer une tentative échouée
        try {
            Livewire::test(Login::class)
                ->fillForm([
                    'email' => 'test@example.com',
                    'password' => 'wrong-password',
                    'remember' => false,
                ])
                ->call('login');
        } catch (\Exception $e) {
            // Ignorer les exceptions de validation
        }

        // Connexion réussie
        Livewire::test(Login::class)
            ->fillForm([
                'email' => 'test@example.com',
                'password' => 'password123',
                'remember' => false,
            ])
            ->call('login');

        // Vérifier que le rate limiter est réinitialisé
        $throttleKey = \Illuminate\Support\Str::transliterate(
            \Illuminate\Support\Str::lower('test@example.com').'|'.request()->ip()
        );

        expect(RateLimiter::attempts($throttleKey))->toBe(0);
    });

    it('regenerates session on successful login', function () {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $oldSessionId = Session::getId();

        Livewire::test(Login::class)
            ->fillForm([
                'email' => 'test@example.com',
                'password' => 'password123',
                'remember' => false,
            ])
            ->call('login');

        expect(Session::getId())->not->toBe($oldSessionId);
    });
});

describe('ConfirmPassword Component', function () {
    it('renders successfully for authenticated users', function () {
        $user = User::factory()->create();

        actingAs($user);

        Livewire::test(ConfirmPassword::class)
            ->assertStatus(200);
    });

    it('validates required password field', function () {
        $user = User::factory()->create();

        actingAs($user);

        Livewire::test(ConfirmPassword::class)
            ->fillForm(['password' => ''])
            ->call('confirmPassword')
            ->assertHasFormErrors(['password' => 'required']);
    });

    it('confirms password with valid credentials', function () {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        actingAs($user);

        Livewire::test(ConfirmPassword::class)
            ->fillForm(['password' => 'password123'])
            ->call('confirmPassword')
            ->assertRedirect(route('home'));

        expect(session('auth.password_confirmed_at'))->not->toBeNull()
            ->and(session('auth.password_confirmed_at'))->toBeInt();
    });

    it('fails password confirmation with wrong password', function () {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        actingAs($user);

        Livewire::test(ConfirmPassword::class)
            ->fillForm(['password' => 'wrong-password'])
            ->call('confirmPassword')
            ->assertHasFormErrors(['password']);

        expect(session('auth.password_confirmed_at'))->toBeNull();
    });

    it('stores password confirmation timestamp in session', function () {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        actingAs($user);

        $beforeTime = time();

        Livewire::test(ConfirmPassword::class)
            ->fillForm(['password' => 'password123'])
            ->call('confirmPassword');

        $afterTime = time();
        $confirmedAt = session('auth.password_confirmed_at');

        expect($confirmedAt)->toBeGreaterThanOrEqual($beforeTime)
            ->and($confirmedAt)->toBeLessThanOrEqual($afterTime);
    });

    it('redirects to intended url after password confirmation', function () {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        actingAs($user);

        session()->put('url.intended', '/dashboard');

        Livewire::test(ConfirmPassword::class)
            ->fillForm(['password' => 'password123'])
            ->call('confirmPassword')
            ->assertRedirect('/dashboard');
    });

    it('redirects to home by default when no intended url', function () {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        actingAs($user);

        Livewire::test(ConfirmPassword::class)
            ->fillForm(['password' => 'password123'])
            ->call('confirmPassword')
            ->assertRedirect(route('home'));
    });

    it('validates password is a string', function () {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        actingAs($user);

        Livewire::test(ConfirmPassword::class)
            ->fillForm(['password' => ['not', 'a', 'string']])
            ->call('confirmPassword')
            ->assertHasFormErrors(['password' => 'string']);
    });
});
