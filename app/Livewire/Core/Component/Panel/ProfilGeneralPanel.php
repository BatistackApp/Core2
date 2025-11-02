<?php

namespace App\Livewire\Core\Component\Panel;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use Livewire\Component;

class ProfilGeneralPanel extends Component implements HasSchemas, HasActions
{
    use InteractsWithSchemas, InteractsWithActions;

    public ?array $data = [];
    public User $user;

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->form->fill($this->user->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom'),

                TextInput::make('email')
                    ->label('Email'),
            ])
            ->statePath('data')
            ->model($this->user);
    }

    public function updateUser(): void
    {
        try {
            $this->user->update($this->data);

            flash()->success('Mise à jour de vos informations réussi')
                ->setTitle('Mise à jour de vos informations');


        }catch (\Exception $e) {
            \Log::emergency($e->getMessage());

            flash()
                ->error($e->getMessage())
                ->setTitle('Erreur Server');
        }
    }

    public function deleteUserAction(): Action
    {
        return Action::make('delete')
            ->label('Supprimer mon compte')
            ->button()
            ->icon(Heroicon::XMark)
            ->size(Size::Large)
            ->extraAttributes([
                'class' => 'kt-btn kt-btn-destructive text-red-600'
            ])
            ->action(function () {
                $this->user->delete();
            });
    }
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.core.component.panel.profil-general-panel');
    }
}
