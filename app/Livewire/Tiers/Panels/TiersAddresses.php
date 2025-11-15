<?php

namespace App\Livewire\Tiers\Panels;

use App\Models\Core\Country;
use App\Models\Tiers\Tiers;
use App\Models\Tiers\TiersAddress;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class TiersAddresses extends Component implements HasTable, HasSchemas, HasActions
{
    use InteractsWithTable, InteractsWithForms, InteractsWithActions;

    public Tiers $tiers;

    public function mount(Tiers $tiers)
    {
        $this->tiers = $tiers;
    }

    /**
     * Schéma du formulaire pour une adresse
     */
    protected function getAddressFormSchema(): array
    {
        return [
            TextInput::make('address')->label('Adresse (Ligne 1)')->required(),
            TextInput::make('code_postal')->label('Code Postal')->required(),
            TextInput::make('ville')->label('Ville')->required(),
            Select::make('pays')->label('Pays')
                ->options(Country::all()->pluck('name', 'name'))
                ->searchable()
                ->required(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            // Pointe la requête sur les adresses de ce Tiers uniquement
            ->query($this->tiers->addresses()->getQuery())
            ->emptyStateHeading("Aucune Adresse pour ce tiers")
            ->emptyStateActions([
                CreateAction::make()
                    ->label('Ajouter une adresse')
                    ->model(TiersAddress::class)
                    ->schema($this->getAddressFormSchema())
                    ->mutateDataUsing(function (array $data): array {
                        // Ajoute l'ID du tiers automatiquement
                        $data['tiers_id'] = $this->tiers->id;
                        return $data;
                    })
                    ->modalHeading('Nouvelle Adresse'),
            ])
            ->columns([
                TextColumn::make('address')->label('Adresse'),
                TextColumn::make('code_postal')->label('Code Postal'),
                TextColumn::make('ville')->label('Ville'),
                TextColumn::make('pays')->label('Pays'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Ajouter une adresse')
                    ->model(TiersAddress::class)
                    ->schema($this->getAddressFormSchema())
                    ->mutateDataUsing(function (array $data): array {
                        // Ajoute l'ID du tiers automatiquement
                        $data['tiers_id'] = $this->tiers->id;
                        return $data;
                    })
                    ->modalHeading('Nouvelle Adresse'),
            ])
            ->recordActions([
                EditAction::make()
                    ->tooltip("Editer l'adresse")
                    ->iconButton()
                    ->schema($this->getAddressFormSchema())
                    ->mutateDataUsing(function (array $data, ?Model $record): array {
                        // Ajoute l'ID du tiers automatiquement
                        $data['tiers_id'] = $this->tiers->id;
                        $data['address'] = $record->address;
                        $data['code_postal'] = $record->code_postal;
                        $data['ville'] = $record->ville;
                        $data['pays'] = $record->pays;
                        return $data;
                    })
                    ->using(fn (array $data) => $this->tiers->addresses()->updateOrCreate(['id' => $data['id']], $data)),

                DeleteAction::make()
                    ->tooltip('Supprimer la adresse')
                    ->iconButton()
                    ->requiresConfirmation()
                    ->using(fn (Model $record): bool => !$record->delete())
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function render()
    {
        return view('livewire.tiers.panels.tiers-addresses');
    }
}
