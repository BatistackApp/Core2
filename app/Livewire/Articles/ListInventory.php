<?php

namespace App\Livewire\Articles;

use App\Models\Articles\Inventory;
use App\Trait\Articles\InventoryFormSchema;
use Filafly\IdentityColumn\Tables\Columns\IdentityColumn;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Enums\IconSize;
use Filament\Support\Enums\Size;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.base')]
class ListInventory extends Component implements HasTable, HasSchemas, HasActions
{
    use InteractsWithTable, InteractsWithSchemas, InteractsWithActions, InventoryFormSchema;

    public function table(Table $table): Table
    {
        return $table
            ->heading(fn () => 'Inventaires ('.Inventory::count().')')
            ->description("Gestion des inventaires de l'entreprise")
            ->emptyStateHeading("Aucun inventaire actuellement")
            ->query(Inventory::query())
            ->columns([
                TextColumn::make('inventory_date')
                    ->sortable()
                    ->label("Date")
                    ->date('d/m/Y'),

                TextColumn::make('code')
                    ->searchable()
                    ->label("Référence"),

                TextColumn::make('warehouse.name')
                    ->label("Entrepot"),

                TextColumn::make('created_at')
                    ->toggleable()
                    ->label("Créer le")
                    ->date(),

                IdentityColumn::make('user_id')
                    ->label("Créer par")
                    ->avatar(fn (?Model $record) => $record->user->initials())
                    ->primary(fn (?Model $record) => $record->user->name)
                    ->secondary(fn (?Model $record) => $record->user->email),

                TextColumn::make('status')
                    ->sortable()
                    ->label("Statut")
                    ->badge()
                    ->icon(fn (?Model $record) => $record->status->icon())
                    ->color(fn (?Model $record) => $record->status->color())
                    ->formatStateUsing(fn (?Model $record) => $record->status->label()),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make('create')
                    ->icon(Heroicon::PlusCircle)
                    ->iconButton()
                    ->iconSize(IconSize::TwoExtraLarge)
                    ->tooltip("Créer un inventaire")
                    ->schema($this->getSchemaFormInventory())
                    ->modalHeading("Nouvelle Inventaire")
                    ->modalWidth(Width::FourExtraLarge)
                    ->using(function (array $data) {
                        Inventory::create($data);
                    }),
            ])
            ->toolbarActions([])
            ->recordActions([]);
    }

    public function render()
    {
        return view('livewire.articles.list-inventory');
    }
}
