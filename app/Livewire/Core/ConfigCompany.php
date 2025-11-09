<?php

namespace App\Livewire\Core;

use App\Models\Core\Company;
use App\Models\Core\Country;
use App\Services\Siren;
use App\Services\VatValidator;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\View\Components\ModalComponent;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ConfigCompany extends Component implements HasSchemas, HasActions
{
    use InteractsWithSchemas, InteractsWithActions;

    public ?array $data = [];
    public Company $company;

    public function mount()
    {
        if (!auth()->check()) {
            abort(401);
        }
        $this->company = Company::first();
        $this->form->fill($this->company->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informations générales')
                ->schema([
                    TextInput::make('name')
                        ->label('Nom de l\'entreprise'),

                    TextInput::make('address')
                        ->label('Adresse de l\'entreprise')
                        ->default(fn (?Model $record) => $record->address),

                    Grid::make(3)
                        ->schema([
                            TextInput::make('code_postal')
                                ->label('Code postal'),

                            TextInput::make('ville')
                                ->label('Ville'),

                            Select::make('pays')
                                ->label('Pays')
                                ->options(Country::query()->pluck('name', 'name')),
                        ])
                ]),

            Section::make('Coordonnées')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('phone')
                                ->label('Téléphone')
                                ->tel(),

                            TextInput::make('fax')
                                ->label('Fax')
                                ->tel(),
                        ]),

                    TextInput::make('email')
                        ->label('Email')
                        ->email(),

                    TextInput::make('web')
                        ->label('Site web')
                        ->url(),
                ]),

            Section::make('Informations Fiscales')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('siret')
                                ->label("Siret")
                                ->mask('99999999999999'),

                            Action::make('verifySiren')
                                ->label('Vérifier le SIREN')
                                ->action(fn (Get $get) => $this->verifySiren($get('siret'))),
                            TextInput::make('ape')
                                ->label('Code APE/NAF'),

                            TextInput::make('capital')
                                ->label('Capital Social'),
                        ]),

                    TextInput::make('rcs')
                        ->label('RCS'),

                    Toggle::make('tva')
                        ->label("Dispose d'un numéro de TVA intracommunautaire")
                        ->live(),

                    Grid::make(2)
                        ->visible(fn (Get $get) => $get('tva'))
                        ->schema([
                            TextInput::make('num_tva')
                                ->label('Numéro TVA intracommunautaire')
                                ->mask('aa99999999999'),

                            Action::make('verifyVat')
                                ->label('Vérifier le numéro de TVA')
                                ->action(fn (Get $get) => $this->verifVat($get('num_tva'))),
                        ])
                ])
        ])
        ->statePath('data')
        ->model($this->company);
    }

    public function verifySiren(?string $siret = null): bool
    {
        $siretValue = $siret ?? $this->data['siret'] ?? null;

        if (!empty($siretValue)) {
            $verify = app(Siren::class)->call($siretValue, etab: true, type: 'verify');

            if ($verify) {
                sweetalert()
                    ->success("Le SIRET est valide");
                return true;
            } else {
                sweetalert()
                    ->error("Le SIRET n'est pas valide");
                return false;
            }
        } else {
            sweetalert()
                ->warning("Veuillez renseigner le SIRET");
            return false;
        }
    }

    public function verifVat(?string $numTva = null): bool
    {
        $numTvaValue = $numTva ?? $this->data['num_tva'] ?? null;

        if (!empty($numTvaValue)) {
            $verify = app(VatValidator::class)->isValid($numTvaValue);

            if ($verify) {
                sweetalert()
                    ->success("Le numéro de TVA est valide");
                return true;
            } else {
                sweetalert()
                    ->error("Le numéro de TVA n'est pas valide");
                return false;
            }
        } else {
            sweetalert()
                ->warning("Veuillez renseigner le numéro de TVA");
            return false;
        }
    }

    public function updateCompany()
    {
        $data = $this->form->getState();
        unset($data['tva']);

        $this->company->update($data);

        sweetalert()
            ->success("Configuration mise à jour avec succès");

        Notification::make()
            ->title("Information société")
            ->body("Les informations de la société ont été mise à jour")
            ->success()
            ->sendToDatabase(auth()->user());
    }
    public function render()
    {
        return view('livewire.core.config-company');
    }
}
