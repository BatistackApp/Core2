<?php

namespace App\Trait\Core;

use App\Models\Comptabilite\PlanComptable;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;

trait PlanComptableSchema
{
    public function getFormSchema(): array
    {
        return [
            Grid::make(4)
                ->schema([
                    TextInput::make('code')
                        ->label("Code Comptable")
                        ->required()
                        ->columnSpan(1),

                    TextInput::make('account')
                        ->label("Libellé")
                        ->columnSpan(2),

                    Select::make('type')
                        ->label("Type de Compte")
                        ->required()
                        ->options([
                            'Fonds propres' => 'Fonds propres',
                            'Passif immobilisé' => 'Passif immobilisé',
                            'Actifs circulants' => 'Actifs circulants',
                            'Actifs immobilisés' => 'Actifs immobilisés',
                            'Payable',
                            'Dettes à court terme' => 'Dettes à court terme',
                            'Client' => 'Client',
                            'Banque et espèces' => 'Banque et espèces',
                            'Charges' => 'Charges',
                            'Revenus' => 'Revenus',
                            'Autres produits' => 'Autres produits',
                            "Bénéfices de l'exercice en cours" => "Bénéfices de l'exercice en cours"
                        ])
                ]),

            Grid::make(3)
                ->schema([
                    Toggle::make('lettrage')
                        ->label("Prise en charge du lettrage"),

                    TextInput::make('principal')
                        ->label("Compte Principal")
                        ->step(1)
                        ->numeric()
                        ->maxValue(9),

                    TextInput::make('initial')
                        ->label("Montant Initial du compte"),
                ])
        ];
    }

    public function submitSchema(array $data): void
    {
        PlanComptable::updateOrCreate(['id' => $data['id']], $data);
    }
}
