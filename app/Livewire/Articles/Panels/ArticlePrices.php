<?php

namespace App\Livewire\Articles\Panels;

use App\Models\Articles\ArticlePrice;
use App\Models\Articles\Articles;
use App\Trait\Articles\ArticlesFormSchema;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ArticlePrices extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions, InteractsWithSchemas, InteractsWithTable, ArticlesFormSchema;

    public Articles $article;

    public function mount(Articles $article)
    {
        $this->article = $article;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->article->prices()->getQuery())
            ->emptyStateHeading("Aucun prix disponible pour cet article")
            ->emptyStateActions([
                CreateAction::make()
                    ->label('Ajouter un prix')
                    ->model(ArticlePrice::class)
                    ->schema($this->getPriceFormSchema())
                    ->mutateDataUsing(function (array $data) {
                        $data['articles_id'] = $this->article->id;
                        return $data;
                    })
                    ->using(function (array $data) {
                        ArticlePrice::create([
                            'articles_id' => $data['articles_id'],
                            'tiers_id' => $data['tier_id'],
                            'type_price' => $data['type_price'],
                            'price_level_name' => $data['price_level_name'],
                            'min_quantity' => $data['min_quantity'],
                            'price_ht' => $data['price_ht'],
                        ]);
                    })
            ])
            ->columns([
                TextColumn::make('tiers.name')
                    ->label('Tiers')
                    ->default('Prix Général'),

                TextColumn::make('price_ht')
                    ->label('Prix HT')
                    ->money('eur')
                    ->sortable(),

                TextColumn::make('type_price')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === 'achat' ? "Achat" : "Vente")
                    ->color(fn (string $state) => $state === 'achat' ? 'warning' : 'success'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Ajouter un prix')
                    ->model(ArticlePrice::class)
                    ->schema($this->getPriceFormSchema())
                    ->mutateDataUsing(function (array $data): array {
                        $data['articles_id'] = $this->article->id;
                        return $data;
                    })
                    ->modalHeading('Nouveau Prix'),
            ])
            ->recordActions([
                EditAction::make()->schema($this->getPriceFormSchema()),
                DeleteAction::make(),
            ]);
    }

    public function render()
    {
        return view('livewire.articles.panels.article-prices');
    }
}
