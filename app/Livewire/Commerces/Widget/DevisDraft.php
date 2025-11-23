<?php

namespace App\Livewire\Commerces\Widget;

use App\Enums\Commerces\StatusDevis;
use App\Models\Commerces\Devis;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DevisDraft extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Devis::where('status', StatusDevis::DRAFT)->limit(3)->newQuery())
            ->paginated(false)
            ->emptyStateHeading("Aucun devis en brouillon")
            ->heading("Devis en brouillon ")
            ->columns([
                TextColumn::make('num_devis')
                    ->label('')
                    ->url(fn (?Model $record) => route('commerces.devis.show', $record)),

                TextColumn::make('tiers.name')
                    ->label('')
                    ->url(fn (?Model $record) => route('tiers.show', $record->tiers)),

                TextColumn::make('amount_ttc')
                    ->label('')
                    ->numeric()
                    ->summarize(Sum::make()->money('EUR'))
            ]);
    }
}
