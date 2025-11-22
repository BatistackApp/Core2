<?php

namespace App\Livewire\Articles\Panels;

use App\Models\Articles\Inventory;
use App\Models\Articles\InventoryLine;
use App\Trait\Articles\InventoryFormSchema;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class InventoryArticles extends Component implements HasSchemas, HasActions, HasTable
{
    use InteractsWithSchemas, InteractsWithActions, InteractsWithTable, InventoryFormSchema;

    public Inventory $inventory;

    public function mount(Inventory $inventory)
    {
        $this->inventory = $inventory;
        //dd($this->inventory->lines()->with('article')->get());
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->inventory->lines()->with('article')->getQuery())
            ->heading("Liste des articles (" . $this->inventory->lines()->count() . ")")
            ->emptyStateHeading("Aucun article dans cet inventaire")
            ->emptyStateDescription("Ajouter un produit pour commencer")
            ->emptyStateActions([
                CreateAction::make('create')
                    ->icon(Heroicon::PlusCircle)
                    ->label("Ajouter un produit")
                    ->schema($this->getSchemaFormAddProductInventory()),
            ])
            ->headerActions([
                CreateAction::make('create')
                    ->icon(Heroicon::PlusCircle)
                    ->label("Ajouter un produit")
                    ->schema($this->getSchemaFormAddProductInventory())
                    ->mutateDataUsing(function (array $data) {
                        $data['inventory_id'] = $this->inventory->id;
                        return $data;
                    })
                    ->using(function (array $data) {
                        InventoryLine::create($data);
                    }),
            ])
            ->columns([
                TextColumn::make('inventory.warehouse_id')
                    ->label('Entrepot')
                    ->description(fn(?Model $record) => !empty($record->location) ? "Localisation: " . $record->location : "")
                    ->formatStateUsing(fn(?Model $record) => $record->inventory->warehouse->name),

                TextColumn::make('article.name')
                    ->label('Article/Produit')
                    ->icon(Heroicon::ArchiveBox),

                TextColumn::make('expected_quantity')
                    ->alignCenter()
                    ->label("Qte Attendue"),

                TextColumn::make('real_quantity')
                    ->alignCenter()
                    ->label('Qte Réel'),
            ])
            ->recordActions([
                EditAction::make('edit')
                    ->iconButton()
                    ->tooltip("Editer")
                    ->fillForm(fn(?Model $record) => $record->toArray())
                    ->schema($this->getSchemaFormAddProductInventory())
                    ->using(function (array $data, ?Model $record) {
                        $record->update($data);
                    }),

                DeleteAction::make('delete')
                    ->iconButton()
                    ->tooltip("Supprimer")
                    ->requiresConfirmation()
                    ->modalHeading("Supprimer cette article de l'inventaire")
                    ->using(function (?Model $record) {
                        $record->delete();
                    }),
            ])
            ->toolbarActions([

            ]);
    }

    public function render()
    {
        return view('livewire.articles.panels.inventory-articles');
    }
}
