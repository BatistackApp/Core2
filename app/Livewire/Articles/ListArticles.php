<?php

namespace App\Livewire\Articles;

use App\Enums\Articles\ArticleType;
use App\Models\Articles\Articles;
use App\Trait\Articles\ArticlesFormSchema;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.base')]
class ListArticles extends Component implements HasTable, HasSchemas, HasActions
{
    use InteractsWithTable, InteractsWithSchemas, InteractsWithActions, ArticlesFormSchema;

    public function table(Table $table): Table
    {
        return $table
            ->query(Articles::with('category')->newQuery())
            ->emptyStateHeading("Aucun articles")
            ->columns([
                TextColumn::make('reference')
                    ->label('Référence')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Libellé')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type_article')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (?Model $record) => $record->type_article->label())
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->badge()
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (?Model $record) => $record->category->name),

                TextColumn::make('unit.symbol')
                    ->label('Unité')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Type')
                    ->options(ArticleType::class),
                SelectFilter::make('article_category_id')
                    ->label('Catégorie')
                    ->relationship('category', 'name'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Nouvel Article')
                    ->model(Articles::class)
                    ->schema($this->getSchemaFormArticles())
                    ->modalHeading('Créer un Article ou Ouvrage')
                    ->modalWidth('3xl')
                    ->using(function (array $data) {
                        Articles::create($data);
                    }),
            ])
            ->recordActions([
                Action::make('view')
                    ->iconButton()
                    ->icon(Heroicon::Eye)
                    ->tooltip("Fiche de l'article")
                    ->url(fn (?Model $record) => route('articles.show', $record)),

                EditAction::make()
                    ->iconButton()
                    ->tooltip("Modifier")
                    ->schema($this->getSchemaFormArticles())
                    ->model(Articles::class)
                    ->modalWidth('3xl')
                    ->using(fn (array $data, ?Model $record) => $record->update($data)),

                DeleteAction::make()
                    ->iconButton()
                    ->color('danger')
                    ->tooltip('Supprimer')
                    ->requiresConfirmation()
                    ->modalHeading("Supprimer l'article")
                    ->using(fn (?Model $record) => $record->delete()),
            ]);
    }

    public function render()
    {
        return view('livewire.articles.list-articles');
    }
}
