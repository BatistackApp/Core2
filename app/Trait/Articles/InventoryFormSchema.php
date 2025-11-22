<?php

namespace App\Trait\Articles;

use App\Models\Core\Country;
use App\Models\Core\Warehouse;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

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
}
