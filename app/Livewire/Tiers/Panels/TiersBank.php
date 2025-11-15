<?php

namespace App\Livewire\Tiers\Panels;

use App\Jobs\Bank\InitiatePayment;
use App\Models\Banque\BankAccount;
use App\Models\Core\Bank;
use App\Models\Core\Option;
use App\Models\Tiers\Tiers;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Intervention\Validation\Rules\Bic;
use Intervention\Validation\Rules\Iban;
use Livewire\Component;

class TiersBank extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions, InteractsWithSchemas, InteractsWithTable;

    public Tiers $tiers;

    public function mount(Tiers $tiers)
    {
        $this->tiers = $tiers;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->tiers->banks()->getQuery())
            ->columns([
                TextColumn::make('iban')
                    ->label("IBAN/BIC")
                    ->description(fn (?Model $record): string => $record->bic)
            ])
            ->headerActions([
                CreateAction::make()
                    ->label("Ajouter un compte")
                    ->model(TiersBank::class)
                    ->schema($this->getBankFormSchema())
                    ->mutateDataUsing(function (array $data): array {
                        // Ajoute l'ID du tiers automatiquement
                        $data['tiers_id'] = $this->tiers->id;
                        return $data;
                    })
                    ->modalHeading('Nouvelle Banque')
                    ->using(function (array $data) {
                        $this->tiers->banks()->create($data);
                    })
            ])
            ->recordActions([
                EditAction::make()
                    ->tooltip("Editer le compte")
                    ->iconButton()
                    ->schema($this->getBankFormSchema())
                    ->mutateDataUsing(function (array $data, ?Model $record): array {
                        // Ajoute l'ID du tiers automatiquement
                        $data['tiers_id'] = $this->tiers->id;
                        $data['iban'] = $record->iban;
                        $data['bic'] = $record->bic;
                        $data['bank_id'] = $record->bank_id;
                        $data['default'] = $record->default;
                        return $data;
                    })
                    ->using(fn (array $data) => $this->tiers->banks()->updateOrCreate(['id' => $data['id']], $data)),

                DeleteAction::make()
                    ->tooltip('Supprimer le compte')
                    ->iconButton()
                    ->requiresConfirmation()
                    ->using(fn (Model $record): bool => !$record->delete()),

                Action::make('makeTransfer')
                    ->iconButton()
                    ->icon(Heroicon::CurrencyEuro)
                    ->visible(fn () => Option::where('slug', 'aggregation-bancaire')->exists())
                    ->tooltip("Effectuer un virement")
                    ->schema($this->getVirFormSchema())
                    ->requiresConfirmation()
                    ->action(function (array $data, ?Model $record) {
                        $bank_account = BankAccount::find($data['bank_account_id']);
                        dispatch(new InitiatePayment($record, $bank_account, $data['motif'], $data['montant']))->delay(now()->addMinutes(5));
                    }),
            ]);
    }

    public function render()
    {
        return view('livewire.tiers.panels.tiers-bank');
    }

    private function getBankFormSchema()
    {
        return [
            TextInput::make('iban')
                ->label('IBAN')
                ->rules([new Iban()])
                ->required(),

            TextInput::make('bic')
                ->label('BIC')
                ->rules([new Bic()])
                ->required(),

            Select::make('bank_id')
                ->label("Banque")
                ->required()
                ->options(Bank::all()->pluck('name', 'id'))
                ->searchable(),

            Toggle::make('default')
                ->label("Compte par default"),
        ];
    }

    private function getVirFormSchema()
    {
        return [
            Grid::make()
                ->columns(2)
                ->schema([
                    Select::make('bank_account_id')
                        ->live()
                        ->label("Compte Bancaire")
                        ->options(BankAccount::all()->pluck('name', 'id'))
                        ->required(),

                    TextEntry::make('balance')
                        ->label("Disponible sur le compte")
                        ->default(0)
                        ->visible(fn (Get $get) => $get('bank_account_id'))
                        ->formatStateUsing(function (Get $get) {
                            $bank_account = BankAccount::find($get('bank_account_id'));
                            return \Number::currency($bank_account->current_balance, 'EUR', 'FR', 2);
                        })
                ]),

            TextInput::make('motif')
                ->label("Motif du virement")
                ->required(),

            TextInput::make('montant')
                ->label("Montant")
                ->required(),
        ];
    }
}
