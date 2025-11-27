<?php

namespace App\Trait\Tiers;

use App\Enums\Tiers\TiersNature;
use App\Enums\Tiers\TiersType;
use App\Models\Comptabilite\PlanComptable;
use App\Models\Core\ConditionReglement;
use App\Models\Core\ModeReglement;
use App\Models\Tiers\Tiers;
use App\Services\Siren;
use App\Trait\Core\PlanComptableSchema;
use DB;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

trait TiersFormSchema
{
    use PlanComptableSchema;
    /**
     * Définit le schéma de formulaire complet pour un Tiers (utilisé pour la création et l'édition)
     */
    protected function getTiersFormSchema(): array
    {
        return [
            Step::make('Général')
                ->description('Information de contact')
                ->icon(Heroicon::InformationCircle)
                ->schema([
                    Select::make('siren') // On sauvegarde le numéro SIREN (clé unique)
                        ->label("Rechercher un établissement")
                        ->searchable()
                        ->getSearchResultsUsing(function (string $search, Siren $service) {
                            $results = $service->searchEntreprise($search)['results'];
                            \Log::debug("APPEL CALL SIREN API: ", [$results]);

                            return collect($results)
                                ->mapWithKeys(function ($item) {
                                    // Construction du label affiché dans la liste
                                    // Ex: "Vortech Studio (123456789) - 10 Rue de la Paix..."
                                    $siren = $item['siren'] ?? '';
                                    $name = $item['nom_complet'] ?? 'Nom inconnu';
                                    $address = $item['siege']['adresse'] ?? '';

                                    $label = "{$name} ({$siren})";
                                    if ($address) {
                                        $label .= " - {$address}";
                                    }

                                    // Format [ 'ValeurStockée' => 'LabelAffiché' ]
                                    return [$siren => $label];
                                })
                                ->toArray();
                        })
                        ->getOptionLabelUsing(function ($value) {
                            // Ici, on gère l'affichage quand le formulaire est chargé avec une valeur existante.
                            // Idéalement, vous devriez faire un appel API pour retrouver le nom à partir du SIREN ($value),
                            // ou stocker le nom dans une autre colonne de votre base.
                            // Pour l'instant, on affiche le SIREN.
                            return "Établissement SIREN : " . $value;
                        })
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Logique pour retrouver les infos complètes si nécessaire
                            // $infos = app(Siren::class)->findByNom($state);
                            // $set('address', $infos->address);
                        }),

                    TextInput::make('name')
                        ->label('Nom')
                        ->required(),

                    TextInput::make('siren')
                        ->label('Siren')
                        ->maxLength(9)
                        ->required(),

                    Select::make('nature')
                        ->label('Nature')
                        ->options(TiersNature::class)
                        ->required()
                        ->live(), // Important pour les champs conditionnels

                    Select::make('type')
                        ->label('Type')
                        ->options(TiersType::class)
                        ->required(),

                ])->columns(2),

            Step::make('Information')
                ->description('Réglement & Comptabilité')
                ->icon(Heroicon::Banknotes)
                ->schema([
                    Toggle::make('tva')
                        ->label('Assujetti à la TVA')
                        ->live(),

                    TextInput::make('num_tva')
                        ->label('Numéro de TVA')
                        ->visible(fn(Get $get) => $get('tva')),

                    TextInput::make('rem_relative')
                        ->label('Remise Relative (%)')
                        ->numeric()
                        ->default(0.00),

                    TextInput::make('rem_fixe')
                        ->label('Remise Fixe (€)')
                        ->numeric()
                        ->default(0.00),


                    Select::make('condition_reglement')
                        ->label('Condition de Réglement')
                        ->options(ConditionReglement::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    Select::make('mode_reglement')
                        ->label('Mode de Réglement')
                        ->options(ModeReglement::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                ])->columns(2),

            Step::make('Banque')
                ->description('Information bancaire')
                ->icon(Heroicon::CurrencyEuro)
                ->schema([
                    TextInput::make('iban')
                        ->label('IBAN'),
                    TextInput::make('bic')
                        ->label('BIC'),
                    Toggle::make('default')
                        ->label('Compte par défaut')
                ])
        ];
    }

    public function getTiersInfoSchema(): array
    {
        return [
            TextEntry::make('info_bodacc.siren'),
            TextEntry::make('info_bodacc.activite_principale'),
            TextEntry::make('info_bodacc.date_creation'),
        ];
    }

    public function submitForm(array $data): void
    {
        try {
            $code_comptable = $data['nature']->value === TiersNature::Client->value ? 232 : 215;
            $lib = \Str::limit(\Str::upper($data['name']), 3, '');

            if ($data['nature']->value === TiersNature::Fournisseur->value) {
                $code = PlanComptable::updateOrCreate(
                    ['code' => '401'.$lib],
                    [
                        'code' => '401'.$lib,
                        'account' => \Str::upper($data['name']),
                        'type' => 'Payable',
                        'lettrage' => false,
                        'principal' => '4',
                        'initial' => 0
                    ]
                );
            } else {
                $code = PlanComptable::updateOrCreate(
                    ['code' => '411'.$lib],
                    [
                        'code' => '411'.$lib,
                        'account' => \Str::upper($data['name']),
                        'type' => 'Client',
                        'lettrage' => false,
                        'principal' => '4',
                        'initial' => 0
                    ]
                );
            }

            $tiers = Tiers::create(
                [
                    'name' => $data['name'],
                    'nature' => $data['nature'],
                    'type' => $data['type'],
                    'siren' => $data['siren'],
                    'tva' => $data['tva'],
                    'num_tva' => $data['num_tva'] ?? null,
                ]
            );

            if ($data['nature'] === TiersNature::Fournisseur) {
                $tiers->supplyProfile()->create([
                    'tva' => $data['tva'],
                    'num_tva' => $data['tva'] ?? $data['num_tva'],
                    'rem_relative' => $data['rem_relative'],
                    'rem_fixe' => $data['rem_fixe'],
                    'code_comptable_general' => $code_comptable,
                    'code_comptable_fournisseur' => $code->id,
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
                    'code_comptable_general' => $code_comptable,
                    'code_comptable_client' => $code->id,
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
            \Log::emergency($exception->getMessage(), [$exception]);

            Notification::make()
                ->danger()
                ->title("Erreur lors de la création du Tiers")
                ->send();
        }
    }
}
