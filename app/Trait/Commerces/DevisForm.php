<?php

namespace App\Trait\Commerces;

use App\Enums\Commerces\TypeDevisLigne;
use App\Models\Articles\Articles;
use App\Models\Chantiers\Chantiers;
use App\Models\Commerces\Devis;
use App\Models\Tiers\Tiers;
use App\Trait\Tiers\TiersFormSchema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

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
                ->live()
                ->searchable()
                ->options(Articles::pluck('name', 'id'))
                ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                    if (!$state) {
                        return;
                    }
                    $tiers = Tiers::find($get('tiers_id'));
                    $article = Articles::find($state);
                    if($article) {
                        $set('libelle', $article->name);
                        $set('qte', 1);
                    }

                    if($tiers) {
                        $puht = $tiers->nature->value === 'client' ? $article->prix_vente_ht : $article->price_achat_ht;
                        $set('puht', $puht);
                    }
                }),

            Select::make('type')
                ->label("Type de Ligne")
                ->options(TypeDevisLigne::class)
                ->required(),

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
                ])
        ];
    }

    public function submitDevis(array $data)
    {
        //dd($data);
        $devis = Devis::create([
            'date_devis' => $data['date_devis'],
            'chantiers_id' => $data['chantiers_id'],
            'tiers_id' => $data['tiers_id'],
        ]);

        foreach ($data['lines'] as $line) {
            $devis->lines()->create([
                'type' => $line['type']->value,
                'libelle' => $line['libelle'],
                'description' => $line['description'],
                'qte' => $line['qte'],
                'puht' => $line['puht'],
                'tva_rate' => $line['tva_rate'],
                'amount_ht' => $line['qte'] * $line['puht'],
                'devis_id' => $devis->id,
                'articles_id' => $line['articles_id'] ?? null
            ]);
        }

        $total_amount_ht = $devis->lines()->sum('amount_ht');
        $total_vat = $total_amount_ht * 20 / 100;

        $devis->amount_ht = $total_amount_ht;
        $devis->amount_ttc = $total_amount_ht + $total_vat;
        $devis->save();
    }

    public function generatePdf(Devis $devis)
    {

    }
}
