<?php

namespace App\Livewire\Commerces\Devis;

use App\Models\Commerces\Devis;
use App\Models\Commerces\DevisLigne;
use App\Trait\Commerces\DevisForm;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.base')]
class ShowDevis extends Component implements HasSchemas, HasActions, HasTable
{
    use InteractsWithSchemas, InteractsWithActions, InteractsWithTable, DevisForm;

    public Devis $devis;

    public function mount(Devis $devis)
    {
        $this->devis = $devis;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(DevisLigne::where('devis_id', $this->devis->id)->newQuery())
            ->heading("Articles du devis")
            ->emptyStateHeading("Aucun article enregistré")
            ->columns([
                TextColumn::make('libelle')
                    ->label("Désignation")
                    ->description(fn (?Model $record) => $record->description),

                TextColumn::make('puht')
                    ->label("P.U.HT")
                    ->money("EUR"),

                TextColumn::make('qte')
                    ->label("Quantité")
                    ->numeric(),

                TextColumn::make('amount_ht')
                    ->label("Montant HT")
                    ->money("EUR"),
            ]);
    }

    public function render()
    {
        return view('livewire.commerces.devis.show-devis');
    }
}
