<?php

namespace App\Livewire\Articles\Panels;

use App\Models\Articles\Articles;
use App\Trait\Articles\ArticlesFormSchema;
use App\Trait\Core\WarehouseSchema;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ArticleStock extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions, InteractsWithSchemas, InteractsWithTable, ArticlesFormSchema, WarehouseSchema;

    public Articles $article;

    public function mount(Articles $article): void
    {
        $this->article = $article;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->article->stocks()->getQuery())
            ->columns([
                TextColumn::make('warehouse.name')
                    ->label('Entrepot'),

                TextColumn::make('quantity')
                    ->label('Quantité Actuel'),

                TextColumn::make('quantity_reserved')
                    ->label("Quantité Réservée"),

                TextColumn::make('article.stock_alert_threshold')
                    ->label('Status')
                    ->badge()
                    ->color(function (?Model $record) {
                        $limit_quantity = $record->article->stock_alert_threshold;
                        $color = 'mono';
                        if ($record->quantity <= $limit_quantity) {
                            $color = 'danger';
                        }  else {
                            $color = 'success';
                        }

                        return $color;
                    })
                    ->formatStateUsing(function (?Model $record) {
                        $limit_quantity = $record->article->stock_alert_threshold;
                        $color = 'mono';
                        if ($record->quantity < $limit_quantity) {
                            $color = 'Stock null';
                        } elseif($record->quantity === $limit_quantity) {
                            $color = 'Stock Bas';
                        } else {
                            $color = 'Ok';
                        }

                        return $color;
                    }),
            ])
            ->headerActions([
                CreateAction::make('create')
                    ->label('Ajouter un stock')
                    ->schema($this->getStockFormSchema())
                    ->mutateDataUsing(function (array $data) {
                        $data['articles_id'] = $this->article->id;
                        return $data;
                    })
                    ->using(function (array $data) {
                        $this->article->stocks()->create($data);
                    }),
            ])
            ->recordActions([
                EditAction::make('edit')
                    ->iconButton()
                    ->tooltip("Editer le stock")
                    ->schema($this->getStockFormSchema())
                    ->using(function (array $data, ?Model $record) {
                        $record->update($data);
                    })
            ]);
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.articles.panels.article-stock');
    }
}
