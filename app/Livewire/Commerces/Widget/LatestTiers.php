<?php

namespace App\Livewire\Commerces\Widget;

use App\Models\Tiers\Tiers;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LatestTiers extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->heading('Les 3 derniers clients ou prospects')
            ->query(fn (): Builder => Tiers::limit(3)->newQuery())
            ->paginated(false)
            ->emptyStateHeading("Aucun tiers enregistrer")
            ->columns([
                TextColumn::make('name')
                    ->label('')
                    ->icon(Heroicon::BuildingOffice)
                    ->url(fn (?Model $record) => route('tiers.show', $record)),

                TextColumn::make('nature')
                    ->label('')
                    ->badge()
                    ->color(fn (?Model $record) => $record->nature->color())
                    ->formatStateUsing(fn (?Model $record) => \Str::upper(\Str::limit($record->nature->label(), 1))),
            ]);
    }
}
