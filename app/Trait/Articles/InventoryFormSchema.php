<?php

namespace App\Trait\Articles;

use App\Enums\Articles\ArticleType;
use App\Models\Articles\Articles;
use App\Models\Core\Country;
use App\Models\Core\Warehouse;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

trait InventoryFormSchema
{
    public function getSchemaFormInventory(): array
    {
        return [
            DatePicker::make('inventory_date')
                ->label("Date de l'inventaire")
                ->required()
                ->default(now()),

            Select::make('warehouse_id')
                ->label("Entrepot")
                ->required()
                ->relationship('warehouse', 'name')
                ->searchable()
                ->createOptionForm(fn () => [
                    TextInput::make('name')->label('Nom de l\'entrepot')->required(),
                    TextInput::make('address')->label('Adresse de l\'entrepot')->required(),
                    TextInput::make('ville')->label('Ville de l\'entrepot')->required(),
                    TextInput::make('code_postal')->label('Ville de l\'entrepot')->required(),
                    Select::make('pays')
                        ->label('Pays')
                        ->options(Country::all()->pluck('name', 'name'))
                        ->required(),
                    Toggle::make('is_default')
                        ->label("Par défault"),
                ]),

            Textarea::make('comment')
                ->label('Commentaire'),
        ];
    }

    public function getSchemaFormAddProductInventory(): array
    {
        return [
            Section::make()
                ->columns(3)
                ->schema([
                    Select::make('articles_id')
                        ->label("Article")
                        ->searchable()
                        ->live()
                        ->options(function () {
                            $collect = collect();
                            Articles::where('type_article', ArticleType::MATERIAL)
                                ->orWhere('type_article', ArticleType::OUVRAGE)
                                ->get()
                                ->each(function ($article) use ($collect) {
                                    $collect->push([$article->id => $article->name]);
                                });

                            return $collect->toArray();
                        })
                        ->afterStateUpdated(function (Set $set, ?string $state) {
                            if (! $state) {
                                return;
                            }

                            $article = Articles::find($state);
                            if($article) {
                                $set('expected_quantity', $article->stocks()->sum('quantity'));
                            }
                        }),

                    TextInput::make('expected_quantity')
                        ->label('Quantité Attendu')
                        ->required(),

                    TextInput::make('real_quantity')
                        ->label("Quantité Réel")
                        ->required(),
                ]),

            TextInput::make('location')
                ->label("Localisation")
                ->helperText('Emplacement dans l\'entrepôt')
        ];
    }
}
