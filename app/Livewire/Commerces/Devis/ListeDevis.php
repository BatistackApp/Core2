<?php

namespace App\Livewire\Commerces\Devis;

use App\Models\Commerces\Devis;
use App\Trait\Commerces\DevisForm;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.base')]
class ListeDevis extends Component implements HasTable, HasSchemas, HasActions
{
    use InteractsWithTable, InteractsWithSchemas, InteractsWithActions, DevisForm;

    public function table(Table $table): Table
    {
        return $table
            ->query(Devis::query())
            ->heading("Liste des devis")
            ->emptyStateHeading("Aucun devis enregistré")
            ->emptyStateActions([

            ])
            ->columns([
                TextColumn::make('num_devis')
                    ->label('Référence')
                    ->searchable()
                    ->sortable()
                    ->url(fn (?Model $record) => route('commerces.devis.show', $record)),

                TextColumn::make('tiers.name')
                    ->label('Tiers')
                    ->icon(Heroicon::BuildingOffice)
                    ->searchable()
                    ->url(fn (?Model $record) => route('tiers.show', $record->tiers)),

                TextColumn::make('date_devis')
                    ->label('Date du devis')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('amount_ttc')
                    ->label("Montant TTC")
                    ->money('EUR')
                    ->summarize(Sum::make('amount_ttc')->money('EUR')),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->sortable()
                    ->color(fn (?Model $record) => $record->status->color())
                    ->formatStateUsing(fn (?Model $record) => $record->status->label()),
            ])
            ->headerActions([
                CreateAction::make('create')
                    ->label("Nouveau Devis")
                    ->icon(Heroicon::PlusCircle)
                    ->modalHeading("Nouveau devis")
                    ->modalWidth(Width::Full)
                    ->schema($this->getSchemaDevis())
                    ->using(fn (array $data) => $this->submitDevis($data)),
            ])
            ->toolbarActions([])
            ->recordActions([])
            ->filters([]);
    }
    public function render()
    {
        return view('livewire.commerces.devis.liste-devis');
    }
}
