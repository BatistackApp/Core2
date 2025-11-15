<?php

namespace App\Livewire\Tiers\Panels;

use App\Enums\Tiers\TiersCivility;
use App\Models\Tiers\Tiers;
use App\Models\Tiers\TiersContact;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class TiersContacts extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions, InteractsWithSchemas, InteractsWithTable;

    public Tiers $tiers;

    public function mount(Tiers $tiers)
    {
        $this->tiers = $tiers;
    }

    protected function getContactSchemaForm(): array
    {
        return [
            Grid::make()
                ->columns(3)
                ->schema([
                    Select::make('civilite')->label('Civilite')
                        ->options(TiersCivility::class),

                    TextInput::make('nom')
                        ->label('Nom'),

                    TextInput::make('prenom')
                        ->label('Prénom'),
                ]),

            TextInput::make('poste')
                ->label('Poste')
                ->columns(3),

            Grid::make()
                ->columns(3)
                ->schema([
                    TextInput::make('email')
                        ->label('Email')
                        ->email(),

                    TextInput::make('tel')
                        ->label('Téléphone')
                        ->tel(),

                    TextInput::make('portable')
                        ->label('Mobile')
                        ->tel(),
                ])
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->tiers->contacts()->getQuery())
            ->emptyStateHeading("Aucun contact définie pour ce tiers")
            ->columns([
                TextColumn::make('nom')
                    ->label("Identité")
                    ->formatStateUsing(function (?Model $record) {
                        return $record->civilite->value." ".$record->nom." ".$record->prenom;
                    }),

                TextColumn::make('poste')
                    ->badge()
                    ->label('Poste'),

                TextColumn::make('email')
                    ->label("Coordonnées")
                    ->formatStateUsing(function (?Model $record) {
                        return $this->getViewCoordonnee($record);
                    })
                    ->html(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Nouveau contact')
                    ->model(TiersContact::class)
                    ->schema($this->getContactSchemaForm())
                    ->mutateDataUsing(function (array $data) {
                        $data['tiers_id'] = $this->tiers->id;
                        return $data;
                    })
                    ->modalHeading("Nouveau contact"),
            ])
            ->recordActions([
                EditAction::make()
                    ->tooltip("Editer le contact")
                    ->iconButton()
                    ->schema($this->getContactSchemaForm())
                    ->mutateDataUsing(function (array $data, ?Model $record) {
                        $data['tiers_id'] = $this->tiers->id;
                        $data['nom'] = $record->nom;
                        $data['prenom'] = $record->prenom;
                        $data['poste'] = $record->poste;
                        $data['email'] = $record->email;
                        $data['tel'] = $record->tel;
                        $data['portable'] = $record->portable;
                        return $data;

                    }),

                DeleteAction::make()
                    ->tooltip("Supprimer le contact")
                    ->iconButton()
                    ->requiresConfirmation()
                    ->modalHeading("Suppression du contact")
                    ->using(function (Model $record) {
                        return $record->delete();
                    })
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function render()
    {
        return view('livewire.tiers.panels.tiers-contacts');
    }

    private function getViewCoordonnee(?Model $record)
    {
        ob_start();
        ?>
        <div class="flex flex-col  gap-1">
            <div class="flex items-center gap-1">
                <i class="ki-filled ki-phone"></i>
                <a href="tel:<?= $record->tel ?>"><?= $record->tel ?></a>
            </div>
            <div class="flex items-center gap-1">
                <i class="ki-filled ki-phone"></i>
                <a href="tel:<?= $record->portable ?>"><?= $record->portable ?></a>
            </div>
            <div class="flex items-center gap-1">
                <i class="ki-filled ki-sms"></i>
                <span><?= $record->email ?></span>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
