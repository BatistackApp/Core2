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
                                ->action(function (Get $get) {
                                    if (!empty($get('siret'))) {
                                        $verify = app(Siren::class)->call($get('siret'), etab: true, type: 'verify');

                                        if ($verify) {
                                            sweetalert()
                                                ->success("Le SIRET est valide");
                                        } else {
                                            sweetalert()
                                                ->error("Le SIRET n'est pas valide");
                                        }
                                    } else {
                                        sweetalert()
                                            ->warning("Veuillez renseigner le SIRET");
                                    }                               
                                }),
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
                                ->action(function (Get $get) {
                                    if (!empty($get('num_tva'))) {
                                        $verify = app(VatValidator::class)->isValid($get('num_tva'));
                                
                                        if ($verify) {
                                            sweetalert()
                                                ->success("Le numéro de TVA est valide");
                                        } else {
                                            sweetalert()
                                                ->error("Le numéro de TVA n'est pas valide");
                                        }
                                    } else {
                                        sweetalert()
                                            ->warning("Veuillez renseigner le numéro de TVA");
                                    }
                                }),  
                        ])
                ])    
        ])
        ->statePath('data')
        ->model($this->company);
    }

    public function updateCompany()
    {
        $data = $this->form->getState();
        unset($data['tva']);

        $this->company->update($data);

        sweetalert()
            ->success("Configuration mise à jour avec succès");
    }
    public function render()
    {
        return view('livewire.core.config-company');
    }
}
