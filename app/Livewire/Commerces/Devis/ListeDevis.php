<?php

namespace App\Livewire\Commerces\Devis;

use App\Enums\Commerces\StatusDevis;
use App\Models\Commerces\Devis;
use App\Models\Core\Option;
use App\Trait\Commerces\DevisForm;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\QueryBuilder\Constraints\DateConstraint;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
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

                TextColumn::make('amount_ht')
                    ->label("Montant HT")
                    ->money('EUR')
                    ->summarize(Sum::make('amount_ht')->money('EUR')),

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
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('generate_pdf')
                        ->label('Générer le PDF')
                        ->action(fn (Collection $records) => null),

                    BulkAction::make('fusion_pdf')
                        ->label('Fusionner les PDF')
                        ->action(fn (Collection $records) => null),

                    BulkAction::make('send')
                        ->label('Envoyer par email')
                        ->action(fn (Collection $records) => null),

                    BulkAction::make('signed')
                        ->label('Demander la signature')
                        ->visible(Option::where('slug', 'pack-signature')->exists())
                        ->action(fn (Collection $records) => null),

                    BulkAction::make('validate')
                        ->label('Valider')
                        ->action(fn (Collection $records) => null),

                    BulkAction::make('signe')
                        ->label('Signer')
                        ->action(fn (Collection $records) => null),

                    BulkAction::make('refused')
                        ->label('Refuser')
                        ->action(fn (Collection $records) => null),

                    BulkAction::make('transform')
                        ->label('Transformer')
                        ->action(fn (Collection $records) => null),

                    BulkAction::make('delete')
                        ->label('Supprimer')
                        ->action(fn (Collection $records) => null),
                ])
            ])
            ->recordActions([
                ActionGroup::make([

                ]),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        DateConstraint::make('date_devis')
                    ]),

                SelectFilter::make('status')
                    ->label('Statut')
                    ->options(StatusDevis::class),
            ]);
    }
    public function render()
    {
        return view('livewire.commerces.devis.liste-devis');
    }
}
