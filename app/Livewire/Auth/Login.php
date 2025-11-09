<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Features;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;

#[Layout('layouts.auth')]
#[Title("Connexion")]
class Login extends Component implements HasSchemas, HasActions
{
    use InteractsWithSchemas, InteractsWithActions;

    public ?array $data = [];

    public function mount()
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->required()
                    ->label(__('fields.email')),

                TextInput::make('password')
                    ->required()
                    ->label(__('fields.password'))
                    ->password(),

                Checkbox::make('remember')
                    ->label(__('fields.remember')),
            ])
            ->statePath('data');
    }

    public function login()
    {
        // Valider le formulaire en premier
        $this->form->validate();

        try {
            $this->ensureIsNotRateLimited();
        } catch (ValidationException $e) {
            // Attacher les erreurs au formulaire pour les tests
            foreach ($e->errors() as $field => $messages) {
                $this->addError("data.{$field}", is_array($messages) ? $messages[0] : $messages);
            }
            return;
        }

        try {
            $user = $this->validateCredentials();
        } catch (ValidationException $e) {
            // Attacher les erreurs au formulaire pour les tests
            foreach ($e->errors() as $field => $messages) {
                $this->addError("data.{$field}", is_array($messages) ? $messages[0] : $messages);
            }
            return;
        }

        if (Features::canManageTwoFactorAuthentication() && $user->hasEnabledTwoFactorAuthentication()) {
            Session::put([
                'login.id' => $user->getKey(),
                'login.remember' => $this->form->getState()['remember'] ?? false,
            ]);

            $this->redirect(route('two-factor.login'), navigate: true);

            return;
        }

        Auth::login($user, $this->form->getState()['remember'] ?? false);

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: '/', navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Validate the user's credentials.
     */
    protected function validateCredentials(): User
    {
        $state = $this->form->getState();
        $user = Auth::getProvider()->retrieveByCredentials(['email' => $state['email']]);

        if (! $user || ! Auth::getProvider()->validateCredentials($user, ['password' => $state['password']])) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return $user;
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        $state = $this->form->getState();
        return Str::transliterate(Str::lower($state['email'] ?? '').'|'.request()->ip());
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
