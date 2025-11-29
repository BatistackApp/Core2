<?php

namespace App\Trait\Core;

use _PHPStan_e870ac104\Nette\Neon\Exception;
use App\Models\Core\Country;
use App\Models\Core\Warehouse;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;

trait WarehouseSchema
{
    public function getWarehouseSchema(): array
    {
        return [
            TextInput::make('name')
                ->label('Nom'),

            TextInput::make('address')
                ->label('Adresse'),

            Grid::make()
                ->columns(3)
                ->schema([
                    TextInput::make('code_postal')
                        ->label('Code Postal'),

                    TextInput::make('ville')
                        ->label('Ville'),

                    Select::make('pays')
                        ->label('Pays')
                        ->options(Country::pluck('name', 'name'))
                        ->searchable(),
                ]),

            Toggle::make('is_default')
                ->label("Entrepot par default"),
        ];
    }

    /**
     * @throws Exception
     */
    public function submitWarehouseSchema(array $data): void
    {
        try {
            Warehouse::create($data);
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
