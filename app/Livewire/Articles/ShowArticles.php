<?php

namespace App\Livewire\Articles;

use App\Models\Articles\Articles;
use App\Trait\Articles\ArticlesFormSchema;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.base')]
class ShowArticles extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions, InteractsWithSchemas, InteractsWithTable, ArticlesFormSchema;

    public Articles $article;

    public function mount(Articles $articles)
    {
        $this->article = $articles;
    }

    /**
     * Définit l'Infolist (la vue "lecture seule") pour l'article.
     */
    public function articleInfolist(Schema $infolist): Schema
    {
        return $infolist
            ->record($this->article)
            ->components([
                Section::make('Informations Générales')
                    ->icon(Heroicon::InformationCircle)
                    ->columns(3)
                    ->schema([
                        TextEntry::make('reference')
                            ->label('Référence'),
                        TextEntry::make('name')
                            ->label('Nom')
                            ->columnSpan(2),
                        TextEntry::make('type_article')
                            ->badge()
                            ->formatStateUsing(fn () => $this->article->type_article->label()),

                        TextEntry::make('category.name')
                            ->label('Catégorie')
                            ->badge(),

                        TextEntry::make('unit.name')
                            ->label('Unité de mesure'),

                        TextEntry::make('vat_rate')
                            ->label('TVA')
                            ->suffix('%'),

                        TextEntry::make('price_achat_ht')
                            ->label("Prix d'achat HT")
                            ->default(0)
                            ->money('EUR'),

                        TextEntry::make('prix_vente_ht')
                            ->label("Prix de vente HT")
                            ->default(0)
                            ->money('EUR'),

                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull()
                            ->markdown(),
                    ]),
            ]);
    }

    /**
     * Définit les actions du header (Modifier, Retour)
     */
    public function getHeaderActions(): array
    {
        return [
            EditAction::make('edit')
                ->label('Modifier')
                ->record($this->article)
                ->schema($this->getSchemaFormArticles()) // Réutilise le trait
                ->modalWidth('3xl')
                ->modalHeading('Modifier l\'Article')
                ->fillForm($this->article->toArray()) // Pré-remplit le formulaire
                ->using(fn () => Notification::make()->success()->title('Article mis à jour')->send()),

            Action::make('back')
                ->label('Retour à la liste')
                ->color('gray')
                ->icon(Heroicon::ArrowUturnLeft)
                ->url(route('articles.index')),
        ];
    }

    public function render()
    {
        return view('livewire.articles.show-articles');
    }
}
