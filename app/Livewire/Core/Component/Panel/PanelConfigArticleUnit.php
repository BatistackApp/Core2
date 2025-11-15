<?php

namespace App\Livewire\Core\Component\Panel;

use App\Models\Articles\Unit;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class PanelConfigArticleUnit extends Component implements HasTable, HasActions, HasSchemas
{
    use InteractsWithTable, InteractsWithActions, InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(Unit::query())
            ->columns([
                TextColumn::make('name')
                    ->label('Unité')
                    ->formatStateUsing(fn (?Model $record) => $record->name." (".$record->symbol.")"),

                TextColumn::make('type')
                    ->label("Type")
                    ->formatStateUsing(fn (?Model $record) => \Str::ucfirst($record->type)),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label("Ajouter une unité")
                    ->model(Unit::class)
                    ->schema($this->getUnitSchema())
                    ->using(function (array $data) {
                        Unit::create($data);
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->iconButton()
                    ->tooltip("Edité l'unité")
                    ->model(fn (?Model $record) => $record)
                    ->schema($this->getUnitSchema()),

                DeleteAction::make()
                    ->iconButton()
                    ->color('danger')
                    ->tooltip("Supprimer l'unité")
                    ->requiresConfirmation()
                    ->using(fn (?Model $record) => $record->delete()),
            ]);
    }

    public function render()
    {
        return view('livewire.core.component.panel.panel-config-article-unit');
    }

    private function getUnitSchema()
    {
        return [
            TextInput::make('name')
                ->label('Désignation'),

            TextInput::make('symbol')
                ->label("Symbole")
                ->hint('Symbole (ex: h, ml, pce, F)'),

            Select::make('type')
                ->label('Type de mesure')
                ->options([
                    'temps' => "Temps",
                    'longueur' => "Longueur",
                    'surface' => "Surface",
                    'volume' => "Volume",
                    'comptage' => "Comptage",
                    'forfait' => "Forfait"
                ]),
        ];
    }
}
