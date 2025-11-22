<?php

namespace App\Livewire\Articles;

use App\Enums\Articles\InventoryStatus;
use App\Models\Articles\Inventory;
use Filafly\IdentityColumn\Infolists\Components\IdentityEntry;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Infolists\Components\TextEntry;
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
class ShowInventory extends Component implements HasSchemas, HasActions, HasTable
{
    use InteractsWithSchemas, InteractsWithActions, InteractsWithTable;

    public Inventory $inventory;

    public function mount(Inventory $inventory)
    {
        $this->inventory = $inventory;
    }

    public function inventoryInfoList(Schema $schema): Schema
    {
        return $schema
            ->record($this->inventory)
            ->components([
                Section::make("Information d'inventaire")
                    ->icon(Heroicon::InformationCircle)
                    ->columns(1)
                    ->schema([
                        TextEntry::make('code')
                            ->label('Référence'),

                        TextEntry::make('inventory_date')
                            ->label("Date de l'inventaire")
                            ->date('d/m/Y'),

                        TextEntry::make('validated_at')
                            ->label("Validé le")
                            ->date('d/m/Y')
                            ->visible(fn () => $this->inventory->status === InventoryStatus::VALIDATED),

                        TextEntry::make('warehouse.name')
                            ->icon(Heroicon::Home)
                            ->label("Entrepot"),

                        TextEntry::make('status')
                            ->label("Statut")
                            ->badge()
                            ->color(fn () => $this->inventory->status->color())
                            ->formatStateUsing(fn () => $this->inventory->status->label())
                            ->icon(fn () => $this->inventory->status->icon()),

                        IdentityEntry::make('user_id')
                            ->label("Suivi par")
                            ->avatar(fn (?Model $record) => $record->user->avatar)
                            ->primary(fn (?Model $record) => $record->user->name)
                            ->secondary(fn (?Model $record) => $record->user->email),

                        TextEntry::make('status')
                            ->label("Nombre d'article")
                            ->badge()
                            ->formatStateUsing(fn () => $this->inventory->lines()->count()),

                        TextEntry::make('code')
                            ->label("Valorisation de l'inventaire")
                            ->badge()
                            ->formatStateUsing(function () {
                                $total = 0;
                                foreach ($this->inventory->lines as $line) {
                                    $total += $line->article->price_achat_ht * $line->real_quantity;
                                }
                                return \Number::currency($total, 'EUR', 'FR');
                            }),
                    ]),
            ]);
    }

    public function getHeaderAction(): array
    {
        return [
            Action::make('return')
                ->label("Retour à la liste")
                ->icon(Heroicon::ArrowUturnLeft)
                ->color('gray')
                ->url(route('articles.inventory')),
        ];
    }

    public function render()
    {
        return view('livewire.articles.show-inventory');
    }
}
