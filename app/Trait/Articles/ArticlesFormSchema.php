<?php

namespace App\Trait\Articles;

use App\Enums\Articles\ArticleType;
use App\Models\Articles\Articles;
use App\Models\Core\Warehouse;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;

trait ArticlesFormSchema
{
    public function getSchemaFormArticles(): array
    {
        return [
            Section::make('Informations de base')
                ->columns(2)
                ->schema([
                    TextInput::make('reference')
                        ->label('Référence')
                        ->required()
                        ->maxLength(255)
                        ->unique(Articles::class, 'reference', ignoreRecord: true),
                    TextInput::make('name')
                        ->label('Nom')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Select::make('type_article')
                        ->label('Type')
                        ->options(ArticleType::class)
                        ->required()
                        ->live(), // Permet de réagir aux changements
                    Select::make('article_category_id')
                        ->label('Catégorie')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->createOptionForm(fn() => [ // Permet de créer une catégorie à la volée
                            TextInput::make('name')->label('Nom de la catégorie')->required(),
                        ])
                        ->required(),
                    Select::make('unit_id')
                        ->label('Unité')
                        ->relationship('unit', 'name')
                        ->searchable()
                        ->createOptionForm(fn() => [ // Permet de créer une unité à la volée
                            TextInput::make('name')->label('Nom (ex: m², h, pièce)')->required(),
                            TextInput::make('symbol')->label('Symbole (ex: m², h, p)')->required(),
                        ])
                        ->required(),
                    TextInput::make('vat_rate')
                        ->label('TVA (%)')
                        ->numeric()
                        ->default(20.00)
                        ->required(),
                    Toggle::make('is_active')
                        ->label('Actif')
                        ->default(true),

                    Toggle::make('is_stock_managed')
                        ->label("Gérer les stocks")
                        ->live()
                        ->default(false),

                    TextInput::make('stock_alert_threshold')
                        ->label("Seuil d'alerte")
                        ->default(0)
                        ->visible(fn (Get $get) => $get('is_stock_managed')),

                    Textarea::make('description')
                        ->label('Description')
                        ->columnSpanFull(),
                ])
        ];
    }

    protected function getPriceFormSchema(): array
    {
        return [
            Grid::make()
                ->columns(2)
                ->schema([
                    Select::make('tiers_id')
                        ->label('Tiers (Client/Fournisseur)')
                        ->relationship('tiers', 'name')
                        ->searchable()
                        ->helperText('Laissez vide pour un tarif général'),

                    Select::make('type_price')
                        ->label("Type de Prix")
                        ->options([
                            'achat' => "Achat",
                            'vente' => "Vente"
                        ]),
                ]),


            TextInput::make('price_level_name')
                ->name("Désignation du prix"),

            TextInput::make('price_ht')
                ->label('Prix HT')
                ->numeric()
                ->required()
                ->default(0.00),

            TextInput::make('min_quantity')
                ->label("Quantité Minimal")
                ->numeric()
                ->required()
                ->default(1),
        ];
    }

    public function getStockFormSchema(): array
    {
        return [
            Select::make('warehouse_id')
                ->label('Entrepot')
                ->options(Warehouse::all()->pluck('name', 'id'))
                ->required(),
        ];
    }
}
