<?php

namespace App\Livewire\Core\Component\Panel;

use App\Models\Articles\ArticleCategory;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class PanelConfigArticleCategory extends Component implements HasTable, HasActions, HasSchemas
{
    use InteractsWithTable, InteractsWithActions, InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(ArticleCategory::query())
            ->columns([
                TextColumn::make('name')
                    ->label("Désignation")
                    ->description(fn (?Model $record) => $record->description),

                TextColumn::make('parent_id')
                    ->label("A une catégorie parente")
                    ->formatStateUsing(fn (?Model $record) => $record->parent->name)
            ])
            ->headerActions([
                CreateAction::make()
                    ->label("Ajouter une catégorie")
                    ->model(ArticleCategory::class)
                    ->schema($this->getCategorySchema())
            ])
            ->recordActions([
                EditAction::make()
                    ->iconButton()
                    ->tooltip("Editer la catégorie")
                    ->model(fn (?Model $record) => $record)
                    ->schema($this->getCategorySchema()),

                DeleteAction::make()
                    ->iconButton()
                    ->color('danger')
                    ->tooltip("Supprimer la catégorie")
                    ->requiresConfirmation()
                    ->using(fn (?Model $record) => $record->delete()),
            ]);
    }

    public function render()
    {
        return view('livewire.core.component.panel.panel-config-article-category');
    }

    private function getCategorySchema()
    {
        return [
            TextInput::make('name')
                ->label("Désignation")
                ->required(),

            Textarea::make('description')
                ->label("Description"),

            Select::make('parent_id')
                ->label("Catégorie Parente")
                ->options(ArticleCategory::pluck('name', 'id')),
        ];
    }
}
