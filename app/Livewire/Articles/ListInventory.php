<?php

namespace App\Livewire\Articles;

use App\Enums\Articles\InventoryStatus;
use App\Models\Articles\Inventory;
use App\Trait\Articles\InventoryFormSchema;
use Filafly\IdentityColumn\Tables\Columns\IdentityColumn;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Enums\IconSize;
use Filament\Support\Enums\Size;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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
                    ->avatar(fn (?Model $record) => $record->user->avatar)
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
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(InventoryStatus::class),
            ])
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
            ->toolbarActions([
                BulkAction::make('delete')
                    ->label('Supprimer')
                    ->requiresConfirmation()
                    ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => $records->each->delete()),
            ])
            ->recordActions([
                Action::make('view')
                    ->iconButton()
                    ->icon(Heroicon::Eye)
                    ->tooltip("Voir l'inventaire")
                    ->url(fn (?Model $record) => route('articles.inventory.show', $record)),

                Action::make('validated')
                    ->iconButton()
                    ->icon(Heroicon::Check)
                    ->color('success')
                    ->tooltip("Valider l'inventaire")
                    ->visible(fn (?Model $record) => $record->status === InventoryStatus::DRAFT)
                    ->requiresConfirmation()
                    ->modalIcon(Heroicon::CheckBadge)
                    ->modalHeading("Cette Inventaire va être valider.")
                    ->action(fn (?Model $record) => $record->validateInventory()),


                DeleteAction::make('delete')
                    ->iconButton()
                    ->tooltip("Supprimer l'inventaire")
                    ->requiresConfirmation()
                    ->modalHeading("Cette Inventaire va être supprimé.")
                    ->visible(fn (?Model $record) => $record->status !== 'validated')
                    ->action(fn (?Model $record) => $record->delete()),
            ]);
    }

    public function render()
    {
        return view('livewire.articles.list-inventory');
    }
}
