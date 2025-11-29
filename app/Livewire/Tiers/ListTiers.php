<?php

namespace App\Livewire\Tiers;

use App\Enums\Tiers\TiersCivility;
use App\Enums\Tiers\TiersNature;
use App\Enums\Tiers\TiersType;
use App\Filament\Exports\Tiers\TiersExporter;
use App\Models\Comptabilite\PlanComptable;
use App\Models\Core\ConditionReglement;
use App\Models\Core\Country;
use App\Models\Core\ModeReglement;
use App\Models\Tiers\Tiers;
use App\Trait\Tiers\TiersFormSchema;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ExportAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.base')]
#[Title('Liste des Tiers')]
class ListTiers extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions, InteractsWithSchemas, InteractsWithTable, TiersFormSchema;

    public function table(Table $table): Table
    {
        return $table
            ->query(Tiers::query())
            ->emptyStateHeading("Aucun Client/Fournisseur disponible dans cette table")
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nature')
                    ->label('Nature')
                    ->color(fn (?Model $record) => $record->nature->color())
                    ->formatStateUsing(fn (?Model $record) => $record->nature->label())
                    ->badge(),
                TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn (?Model $record) => $record->type->label())
                    ->badge(),
                TextColumn::make('contacts.email')
                    ->label('Email')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('contacts.phone')
                    ->label('Téléphone')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('nature')
                    ->label('Nature')
                    ->options(TiersNature::class),

                SelectFilter::make('type')
                    ->label('Type')
                    ->options(TiersType::class),
            ])
            ->headerActions([
                CreateAction::make('create')
                    ->label('Création de Tiers')
                    ->color('primary')
                    ->icon(Heroicon::Plus)
                    ->steps($this->getTiersFormSchema())
                    ->using(function (array $data) {
                        $this->submitForm($data);
                    }),

                ExportAction::make('export')
                    ->exporter(TiersExporter::class),
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('view')
                        ->icon(Heroicon::Eye)
                        ->label("Fiche")
                        ->url(fn (?Model $record) => route('tiers.show', $record)),

                    Action::make('view_bodac')
                        ->icon(Heroicon::BuildingOffice)
                        ->label("Information Société")
                        ->model(fn (?Model $record) => $record)
                        ->schema($this->getTiersInfoSchema()),

                    DeleteAction::make('delete')
                        ->icon(Heroicon::Trash)
                        ->label("Supprimer")
                        ->requiresConfirmation()
                        ->modalHeading('Supprimer le Tiers ?')
                        ->modalDescription("Êtes-vous sûr de vouloir supprimer ce Tiers ?")
                        ->using(function (?Model $record) {
                            $record->delete();
                        })
                ]),
            ]);
    }

    public function render()
    {
        return view('livewire.tiers.list-tiers');
    }
}
