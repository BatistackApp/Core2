<?php

namespace App\Livewire\Commerces\Widget;

use App\Enums\Commerces\StatusCommande;
use App\Models\Commerces\Commande;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CommandeDraft extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Commande::where('status', StatusCommande::PENDING)->limit(3)->newQuery())
            ->paginated(false)
            ->emptyStateHeading("Aucune commande en brouillon")
            ->heading("Commande en brouillon ")
            ->columns([
                TextColumn::make('num_commande')
                    ->label('')
                    ->url(fn (?Model $record) => route('commerces.commande.show', $record)),

                TextColumn::make('tiers.name')
                    ->label('')
                    ->url(fn (?Model $record) => route('tiers.show', $record->tiers)),

                TextColumn::make('amount_ttc')
                    ->label('')
                    ->numeric(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
