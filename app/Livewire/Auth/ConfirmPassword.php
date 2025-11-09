<?php

namespace App\Livewire\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class ConfirmPassword extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public ?array $data = [];

    public function mount()
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('password')
                    ->required()
                    ->string()
                    ->label(__('fields.password'))
                    ->password(),
            ])
            ->statePath('data');
    }

    public function confirmPassword(): void
    {
        // Valider le formulaire en premier
        $this->form->validate();

        $state = $this->form->getState();

        // S'assurer que password est une chaîne de caractères
        $password = is_array($state['password']) ? '' : $state['password'];

        if (!Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $password,
        ])) {
            $this->addError('data.password', __('auth.password'));
            return;
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.confirm-password');
    }
}
