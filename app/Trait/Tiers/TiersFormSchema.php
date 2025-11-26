<?php

namespace App\Trait\Tiers;

use App\Enums\Tiers\TiersNature;
use App\Enums\Tiers\TiersType;
use App\Models\Comptabilite\PlanComptable;
use App\Models\Core\ConditionReglement;
use App\Models\Core\ModeReglement;
use App\Trait\Core\PlanComptableSchema;
use DB;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Support\Icons\Heroicon;

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

                    // --- Champs Fournisseur ---
                    Select::make('code_comptable_general')
                        ->label("Code Comptable Principal")
                        ->options(
                            PlanComptable::query()
                                ->select('id', DB::raw("CONCAT(code, ' - ', account) as label"))
                                ->pluck('label', 'id')
                        )
                        ->searchable()
                        ->createOptionForm($this->getFormSchema())
                        ->required(),

                    Select::make('code_comptable_fournisseur')
                        ->label("Code Comptable Fournisseur")
                        ->options(
                            PlanComptable::query()
                                ->select('id', DB::raw("CONCAT(code, ' - ', account) as label"))
                                ->pluck('label', 'id')
                        )
                        ->searchable()
                        ->createOptionForm($this->getFormSchema()),

                    // --- Champs Client ---
                    Select::make('code_comptable_client')
                        ->label("Code Comptable Client")
                        ->options(
                            PlanComptable::query()
                                ->select('id', DB::raw("CONCAT(code, ' - ', account) as label"))
                                ->pluck('label', 'id')
                        )
                        ->searchable()
                        ->createOptionForm($this->getFormSchema()),


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
}
