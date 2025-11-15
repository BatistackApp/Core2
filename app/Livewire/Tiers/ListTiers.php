<?php

namespace App\Livewire\Tiers;

use App\Enums\Tiers\TiersCivility;
use App\Enums\Tiers\TiersNature;
use App\Enums\Tiers\TiersType;
use App\Filament\Exports\Tiers\TiersExporter;
use App\Models\Comptabilite\PlanComptable;
use App\Models\Core\ConditionReglement;
use App\Models\Core\Country;
use App\Models\Core\ModeReglement;
use App\Models\Tiers\Tiers;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.base')]
#[Title('Liste des Tiers')]
class ListTiers extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions, InteractsWithSchemas, InteractsWithTable;

    public function getSchemaTiers(): array
    {
        return [
            Step::make('Informations Générales')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Nom')
                        ->required(),

                    Select::make('nature')
                        ->label('Nature')
                        ->live()
                        ->options(TiersNature::class)
                        ->required(),

                    Select::make('type')
                        ->label('Type')
                        ->options(TiersType::class)
                        ->required(),

                    TextInput::make('siren')
                        ->label('Siren'),

                    Toggle::make('tva')
                        ->live()
                        ->label("Dispose d'un numéro de TVA Intracommunautaire"),

                    TextInput::make('num_tva')
                        ->label("Numéro TVA Intracommunautaire")
                        ->visible(fn (Get $get) => $get('tva')),
                ]),

            Step::make('address')
                ->label("Adresses")
                ->schema([
                    Repeater::make('addresses')
                        ->columns(2)
                        ->schema([
                            TextInput::make('address')
                                ->label('Adresse Postal'),

                            TextInput::make('code_postal')
                                ->label('Code Postal'),

                            TextInput::make('ville')
                                ->label('Ville'),

                            Select::make('pays')
                                ->label('Pays')
                                ->options(Country::all()->pluck('name', 'name'))
                                ->searchable(),
                        ])
                ]),

            Step::make('contact')
                ->label("Contact")
                ->description("Contact au sein du tiers")
                ->schema([
                    Repeater::make('contacts')
                        ->columns(3)
                        ->schema([
                            Select::make('civilite')
                                ->label("Civilité")
                                ->options(TiersCivility::class)
                                ->searchable(),

                            TextInput::make('nom')
                                ->label('Nom de famille'),

                            TextInput::make('prenom')
                                ->label('Prénom'),

                            TextInput::make('poste')
                                ->label('Poste')
                                ->columns(1),

                            TextInput::make('tel')
                                ->label('Téléphone')
                                ->mask('99 99 99 99 99'),

                            TextInput::make('portable')
                                ->label('Portable')
                                ->mask('99 99 99 99 99'),

                            TextInput::make('email')
                                ->label('Adresse Mail'),
                        ])
                ]),

            Step::make('fournisseur')
                ->label('Fournisseur')
                ->description("Information relative au fournisseur")
                ->visible(fn (Get $get) => $get('nature') === TiersNature::Fournisseur)
                ->columns(2)
                ->schema([
                    TextInput::make('rem_relative')
                        ->label('Remise relative')
                        ->helperText('Utiliser souvent en pourcentage (25%)'),

                    TextInput::make('rem_fixe')
                        ->label('Remise Fixe')
                        ->helperText("Utiliser souvent en numéraire (10,00€)"),

                    Select::make('code_comptable_general')
                        ->label("Code Comptable Principal")
                        ->options(PlanComptable::all()->mapWithKeys(function ($plan) {
                            // La clé de l'array est la 'value' (le code)
                            // La valeur de l'array est le 'label' (l'affichage)
                            return [$plan->id => $plan->code . ' - ' . $plan->account];
                        }))
                        ->searchable(),

                    Select::make('code_comptable_fournisseur')
                        ->label("Code Comptable Fournisseur")
                        ->options(
                            PlanComptable::all()->mapWithKeys(function ($plan) {
                                // La clé de l'array est la 'value' (le code)
                                // La valeur de l'array est le 'label' (l'affichage)
                                return [$plan->id => $plan->code . ' - ' . $plan->account];
                            })
                        )
                        ->searchable(),

                    Select::make('condition_reglement')
                        ->label('Condition de règlement')
                        ->options(ConditionReglement::pluck('name', 'id')),

                    Select::make('mode_reglement')
                        ->label('Mode de règlement')
                        ->options(ModeReglement::pluck('name', 'id')),
                ]),

            Step::make('client')
                ->label('Client')
                ->description("Information relative au client")
                ->visible(fn (Get $get) => $get('nature') === TiersNature::Client)
                ->columns(2)
                ->schema([
                    TextInput::make('rem_relative')
                        ->label('Remise relative')
                        ->helperText('Utiliser souvent en pourcentage (25%)'),

                    TextInput::make('rem_fixe')
                        ->label('Remise Fixe')
                        ->helperText("Utiliser souvent en numéraire (10,00€)"),

                    Select::make('code_comptable_general')
                        ->label("Code Comptable Principal")
                        ->options(
                            PlanComptable::all()->mapWithKeys(function ($plan) {
                                // La clé de l'array est la 'value' (le code)
                                // La valeur de l'array est le 'label' (l'affichage)
                                return [$plan->id => $plan->code . ' - ' . $plan->account];
                            })
                        )
                        ->searchable(),

                    Select::make('code_comptable_client')
                        ->label("Code Comptable Client")
                        ->options(PlanComptable::all()->mapWithKeys(function ($plan) {
                            // La clé de l'array est la 'value' (le code)
                            // La valeur de l'array est le 'label' (l'affichage)
                            return [$plan->id => $plan->code . ' - ' . $plan->account];
                        }))
                        ->searchable(),

                    Select::make('condition_reglement')
                        ->label('Condition de règlement')
                        ->options(ConditionReglement::pluck('name', 'id')),

                    Select::make('mode_reglement')
                        ->label('Mode de règlement')
                        ->options(ModeReglement::pluck('name', 'id')),
                ]),

            Step::make('bank')
                ->label('Informations Bancaires')
                ->description("Informations Bancaire du tiers")
                ->columns(3)
                ->schema([
                    TextInput::make('iban')
                        ->label('IBAN'),

                    TextInput::make('bic')
                        ->label('BIC/SWIFT'),

                    Toggle::make('default')
                        ->label('Compte par default'),
                ])
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Tiers::query())
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nature')
                    ->label('Nature')
                    ->color(fn (?Model $record) => $record->nature->color())
                    ->formatStateUsing(fn (?Model $record) => $record->nature->label())
                    ->badge(),
                TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn (?Model $record) => $record->type->label())
                    ->badge(),
                TextColumn::make('contacts.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('contacts.phone')
                    ->label('Téléphone')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('nature')
                    ->label('Nature')
                    ->options(TiersNature::class),

                SelectFilter::make('type')
                    ->label('Type')
                    ->options(TiersType::class),
            ])
            ->headerActions([
                CreateAction::make('create')
                    ->label('Création de Tiers')
                    ->color('primary')
                    ->icon(Heroicon::Plus)
                    ->steps($this->getSchemaTiers())
                    ->using(function (array $data) {
                        $this->createTiers($data);
                    }),

                ExportAction::make('export')
                    ->exporter(TiersExporter::class),
            ])
            ->recordActions([
                Action::make('view')
                    ->iconButton()
                    ->icon(Heroicon::Eye)
                    ->tooltip("Fiche"),

                DeleteAction::make('delete')
                    ->button()
                    ->iconButton()
                    ->icon(Heroicon::Trash)
                    ->tooltip("Supprimer")
                    ->requiresConfirmation()
                    ->modalHeading('Supprimer le Tiers ?')
                    ->modalDescription("Êtes-vous sûr de vouloir supprimer ce Tiers ?")
                    ->using(function (?Model $record) {
                        $record->delete();
                    })
            ]);
    }

    public function createTiers(array $data): void
    {
        try {
            $tiers = Tiers::create([
                'name' => $data['name'],
                'nature' => $data['nature'],
                'type' => $data['type'],
                'siren' => $data['siren'],
                'tva' => $data['tva'],
                'num_tva' => $data['num_tva'] ?? null,
            ]);

            foreach ($data['addresses'] as $address) {
                $tiers->addresses()->create($address);
            }

            foreach ($data['contacts'] as $contact) {
                $tiers->contacts()->create($contact);
            }

            if ($data['nature'] === TiersNature::Fournisseur) {
                $tiers->supplyProfile()->create([
                    'tva' => $data['tva'],
                    'num_tva' => $data['tva'] ?? $data['num_tva'],
                    'rem_relative' => $data['rem_relative'],
                    'rem_fixe' => $data['rem_fixe'],
                    'code_comptable_general' => $data['code_comptable_general'],
                    'code_comptable_fournisseur' => $data['code_comptable_fournisseur'],
                    'condition_reglement_id' => $data['condition_reglement'],
                    'mode_reglement_id' => $data['mode_reglement'],
                ]);
            }

            if ($data['nature'] === TiersNature::Client) {
                $tiers->customerProfile()->create([
                    'tva' => $data['tva'],
                    'num_tva' => $data['tva'] ?? $data['num_tva'],
                    'rem_relative' => $data['rem_relative'],
                    'rem_fixe' => $data['rem_fixe'],
                    'code_comptable_general' => $data['code_comptable_general'],
                    'code_comptable_client' => $data['code_comptable_client'],
                    'condition_reglement_id' => $data['condition_reglement'],
                    'mode_reglement_id' => $data['mode_reglement'],
                ]);
            }

            if (isset($data['iban'])) {
                $tiers->banks()->create([
                    'iban' => $data['iban'],
                    'bic' => $data['bic'],
                    'bank_id' => 1,
                    'default' => $data['default'] ?? '0'
                ]);
            }

            Notification::make()
                ->success()
                ->title("Tiers créé avec succès")
                ->send();

        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            Notification::make()
                ->danger()
                ->title("Erreur lors de la création du Tiers")
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.tiers.list-tiers');
    }
}
