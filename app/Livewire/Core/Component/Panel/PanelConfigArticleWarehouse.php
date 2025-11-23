<?php

namespace App\Livewire\Core\Component\Panel;

use App\Models\Core\Country;
use App\Models\Core\Warehouse;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class PanelConfigArticleWarehouse extends Component implements HasTable, HasActions, HasSchemas
{
    use InteractsWithTable, InteractsWithActions, InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(Warehouse::query())
            ->columns([
                TextColumn::make('name')
                    ->label("Désignation"),

                TextColumn::make('address')
                    ->label("Adresse")
                    ->formatStateUsing(function (?Model $record) {
                        return $record->address."<br>".$record->code_postal." ".$record->ville."<br>".$record->pays;
                    })
                    ->html(),

                IconColumn::make('is_default')
                    ->label('Par Default')
                    ->boolean()
            ])
            ->headerActions([
                CreateAction::make()
                    ->label("Ajouter un entrepôt")
                    ->schema($this->getWarehouseSchema())
                    ->model(Warehouse::class)
                    ->using(function (array $data) {
                        Warehouse::create($data);
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->tooltip("Editer l'entrepot")
                    ->iconButton()
                    ->model(fn (?Model $record) => $record)
                    ->schema($this->getWarehouseSchema()),

                DeleteAction::make()
                    ->tooltip("Supprimer l'entrepot")
                    ->iconButton()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->using(fn (?Model $record) => $record->delete()),
            ]);
    }

    public function render()
    {
        return view('livewire.core.component.panel.panel-config-article-warehouse');
    }

    private function getWarehouseSchema(): array
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
}
