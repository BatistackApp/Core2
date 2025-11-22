<?php

namespace App\Livewire\Articles;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Models\Articles\Articles;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.base')]
class StockArticles extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions, InteractsWithSchemas, InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Articles::with('category')->where('is_stock_managed', true)->newQuery())
            ->heading("Liste des Stocks")
            ->columns([
                TextColumn::make('reference')
                    ->label("Référence"),

                TextColumn::make('name')
                    ->label("Désignation")
                    ->description(fn (?Model $record) => $record->description),

                TextColumn::make('stock_alert_threshold')
                    ->badge()
                    ->alignCenter()
                    ->color('secondary')
                    ->label('Seuil de stock'),

                TextColumn::make('actual_stock')
                    ->badge()
                    ->color('secondary')
                    ->alignCenter()
                    ->label('Stock actuel')
                    ->default(function (?Model $record) {
                        return $record->stocks()->sum('quantity');
                    }),

                TextColumn::make('reserved_stock')
                    ->badge()
                    ->color('secondary')
                    ->alignCenter()
                    ->label('Stock réservé')
                    ->default(function (?Model $record) {
                        return $record->stocks()->sum('quantity_reserved');
                    }),

                IconColumn::make('stock_status')
                    ->icon(fn (string $state): Heroicon => match($state) {
                        "no_stock" => Heroicon::XCircle,
                        "stock" => Heroicon::CheckCircle,
                        "stock_alert" => Heroicon::ExclamationTriangle,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        "no_stock" => 'danger',
                        "stock" => 'success',
                        "stock_alert" => 'warning',
                    })
                    ->tooltip(fn (string $state): string => match ($state) {
                        "no_stock" => 'Hors Stock',
                        "stock" => 'En Stock',
                        "stock_alert" => 'Alerte de stock',
                    })
                    ->alignCenter(),

            ])
            ->filters([
                SelectFilter::make('stock_status')
                    ->options([
                        'no_stock' => "Hors Stock",
                        'stock' => "En Stock",
                        'stock_alert' => "Alerte de stock",
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['value'] === 'no_stock') {
                            // On filtre les articles dont la relation 'stock' a une quantité <= 0
                            return $query->whereHas('stocks', function ($q) {
                                $q->where('quantity', '<=', 0);
                            });
                        }

                        if ($data['value'] === 'stock') {
                            return $query->whereHas('stocks', function ($q) {
                                $q->where('quantity', '>', 0);
                            });
                        }
                    }),
            ])
            ->headerActions([
                FilamentExportHeaderAction::make('export')
                    ->label("Exporter")
                    ->defaultPageOrientation('landscape')
                    ->formatStates([
                        'stock_status' => fn (?Model $record) => match($record->stock_status) {
                            "no_stock" => "Hors Stock",
                            "stock" => "En Stock",
                        }
                    ])
            ]);
    }

    public function render()
    {
        return view('livewire.articles.stock-articles');
    }
}
