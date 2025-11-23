<?php

namespace App\Trait\Commerces;

use App\Models\Articles\Articles;
use App\Models\Chantiers\Chantiers;
use App\Models\Tiers\Tiers;
use App\Trait\Tiers\TiersFormSchema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;

trait DevisForm
{
    use TiersFormSchema;
    public function getSchemaDevis(): array
    {
        return [
            Grid::make(3)
                ->schema([
                    Select::make('tiers_id')
                        ->label("Tiers")
                        ->searchable()
                        ->required()
                        ->options(Tiers::pluck('name', 'id')),

                    DatePicker::make('date_devis')
                        ->label('Date du devis')
                        ->required(),

                    Select::make('chantiers_id')
                        ->label('Chantiers')
                        ->searchable()
                        ->options(Chantiers::pluck('libelle', 'id')),

                ]),

            Repeater::make('lines')
                ->label("Articles du devis")
                ->schema($this->getSchemaDevisLines()),
        ];
    }

    public function getSchemaDevisLines(): array
    {
        return [
            Select::make('articles_id')
                ->label('Article')
                ->searchable()
                ->options(Articles::pluck('name', 'id')),

            Grid::make(5)
                ->schema([
                    Grid::make(1)
                        ->schema([
                            TextInput::make('libelle')
                                ->label("Libelle")
                                ->required(),

                            Textarea::make('description')
                                ->label('Description'),
                        ]),

                    TextInput::make('qte')
                        ->label('Quantité')
                        ->required(),

                    TextInput::make('puht')
                        ->label('Prix Unitaire HT')
                        ->required(),

                    TextInput::make('tva_rate')
                        ->label("TVA")
                        ->required()
                        ->default(20),

                    TextInput::make('amount_ht')
                        ->label("Montant HT")
                        ->required(),
                ])
        ];
    }

    public function submitDevis(array $data)
    {

    }
}
