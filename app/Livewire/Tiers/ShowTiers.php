<?php

namespace App\Livewire\Tiers;

use App\Enums\Tiers\TiersNature;
use App\Models\Tiers\Tiers;
use App\Services\Siren;
use App\Trait\Tiers\TiersFormSchema;
use DB;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.base')]
#[Title("Fiche du Tiers")]
class ShowTiers extends Component implements HasSchemas, HasActions, HasInfolists
{
    use InteractsWithSchemas, InteractsWithActions, InteractsWithInfolists, TiersFormSchema;

    public Tiers $tiers;

    public function mount(Tiers $tiers)
    {
        $this->tiers = $tiers;
        $this->tiers->load(['addresses', 'contacts', 'customerProfile', 'supplyProfile', 'banks']);
    }

    public function tiersInfoList(Schema $schema): Schema
    {
        return $schema
            ->record($this->tiers)
            ->components([
                Section::make('Informations Générales')
                    ->icon(Heroicon::InformationCircle)
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name')->label('Raison Social'),
                        TextEntry::make('code_tiers')->label('Code Tiers'),
                        TextEntry::make('nature')->badge(),
                        TextEntry::make('type')->badge(),
                        TextEntry::make('email')->label('Email')->icon(Heroicon::Envelope),
                        TextEntry::make('phone')->label('Téléphone')->icon(Heroicon::Phone),
                        TextEntry::make('website')->label('Site Web')->icon(Heroicon::GlobeAlt),
                        TextEntry::make('notes')->label('Notes')->columnSpanFull(),
                    ]),

                // Section pour le Client
                Section::make('Profil Client')
                    ->icon(Heroicon::User)
                    ->columns(3)
                    ->visible($this->tiers->nature === TiersNature::Client)
                    ->schema([
                        TextEntry::make('customerProfile.num_tva')->label('N° TVA')->visible(fn (?Model $record) => $record->tva),
                        TextEntry::make('customerProfile.rem_relative')->label('Remise (%)')->suffix('%'),
                        TextEntry::make('customerProfile.rem_fixe')->label('Remise (€)')->money('eur'),
                        TextEntry::make('customerProfile.conditionReglement.name')->label('Condition Règlement'),
                        TextEntry::make('customerProfile.modeReglement.name')->label('Mode Règlement'),
                    ]),

                // Section pour le Fournisseur
                Section::make('Profil Fournisseur')
                    ->icon(Heroicon::Truck)
                    ->columns(3)
                    ->visible($this->tiers->nature === TiersNature::Fournisseur)
                    ->schema([
                        TextEntry::make('customerProfile.num_tva')->label('N° TVA')->visible(fn (?Model $record) => $record->tva),
                        TextEntry::make('supplyProfile.conditionReglement.name')->label('Condition Règlement'),
                        TextEntry::make('supplyProfile.modeReglement.name')->label('Mode Règlement'),
                        TextEntry::make('supplyProfile.codeComptableGeneral.account') // Suppose un accesseur 'full_label'
                        ->label('Cpt. Général'),
                        TextEntry::make('supplyProfile.codeComptableFournisseur.account') // Suppose un accesseur 'full_label'
                        ->label('Cpt. Fournisseur'),
                    ]),
            ]);
    }

    public function getHeaderActions(): array
    {
        return [
            EditAction::make('edit')
                ->label('Modifier')
                ->record($this->tiers)
                ->schema($this->getTiersFormSchema()) // Réutilise le trait
                ->modalWidth('5xl')
                ->modalHeading('Modifier le Tiers')
                ->fillForm($this->getTiersDataForForm()) // Pré-remplit le formulaire
                ->action(function (array $data): void {
                    $this->saveTiers($data, $this->tiers);
                    $this->tiers->refresh(); // Rafraîchit les données du modèle local
                }),

            Action::make('infoBodaac')
                ->label("Afficher les informations BODAAC")
                ->color('info')
                ->schema($this->getInfoSchema())
                ->modalWidth(Width::FourExtraLarge),

            Action::make('back')
                ->label('Retour à la liste')
                ->color('gray')
                ->icon(Heroicon::ArrowUturnLeft)
                ->url(route('tiers.index')), // Assurez-vous que la route 'tiers.index' existe
        ];
    }

    /**
     * Logique de sauvegarde (identique à celle de ListTiers)
     */
    private function saveTiers(array $data, ?Tiers $tiers = null): void
    {
        try {
            DB::beginTransaction();
            $tiers->update($data); // Mode mise à jour seulement

            // ... (copie exacte de la logique saveTiers de ListTiers pour les relations) ...

            if ($data['nature'] === TiersNature::Fournisseur->value) {
                $tiers->supplyProfile()->updateOrCreate(['tiers_id' => $tiers->id], [
                    'tva' => $data['tva'],
                    'num_tva' => $data['tva'] ? $data['num_tva'] : null,
                    'rem_relative' => $data['rem_relative'],
                    'rem_fixe' => $data['rem_fixe'],
                    'code_comptable_general_id' => $data['code_comptable_general'],
                    'code_comptable_fournisseur_id' => $data['code_comptable_fournisseur'],
                    'condition_reglement_id' => $data['condition_reglement'],
                    'mode_reglement_id' => $data['mode_reglement'],
                ]);
            }

            if ($data['nature'] === TiersNature::Client->value) {
                $tiers->customerProfile()->updateOrCreate(['tiers_id' => $tiers->id], [
                    'tva' => $data['tva'],
                    'num_tva' => $data['tva'] ? $data['num_tva'] : null,
                    'rem_relative' => $data['rem_relative'],
                    'rem_fixe' => $data['rem_fixe'],
                    'code_comptable_general_id' => $data['code_comptable_general'],
                    'code_comptable_client_id' => $data['code_comptable_client'],
                    'condition_reglement_id' => $data['condition_reglement'],
                    'mode_reglement_id' => $data['mode_reglement'],
                ]);
            }

            if (isset($data['iban']) && $data['iban'] !== '') {
                $tiers->banks()->updateOrCreate(['tiers_id' => $tiers->id, 'default' => true], [
                    'iban' => $data['iban'],
                    'bic' => $data['bic'],
                    'bank_id' => 1,
                    'default' => $data['default'] ?? false
                ]);
            }

            DB::commit();
            Notification::make()->success()->title("Tiers mis à jour")->send();

        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            Notification::make()->danger()->title("Erreur lors de la mise à jour")->body($exception->getMessage())->send();
        }
    }

    /**
     * Prépare les données pour le formulaire d'édition
     */
    protected function getTiersDataForForm(): array
    {
        $this->tiers->load(['customerProfile', 'supplyProfile', 'banks']);
        $data = $this->tiers->toArray();

        if ($this->tiers->nature === TiersNature::Client && $this->tiers->customerProfile) {
            $data = array_merge($data, $this->tiers->customerProfile->toArray());
            $data['code_comptable_general'] = $this->tiers->customerProfile->code_comptable_general_id;
            $data['code_comptable_client'] = $this->tiers->customerProfile->code_comptable_client_id;

        } elseif ($this->tiers->nature === TiersNature::Fournisseur && $this->tiers->supplyProfile) {
            $data = array_merge($data, $this->tiers->supplyProfile->toArray());
            $data['code_comptable_general'] = $this->tiers->supplyProfile->code_comptable_general_id;
            $data['code_comptable_fournisseur'] = $this->tiers->supplyProfile->code_comptable_fournisseur_id;
        }

        if ($bank = $this->tiers->banks->firstWhere('default', true) ?? $this->tiers->banks->first()) {
            $data = array_merge($data, $bank->toArray());
        }

        // Renommer les clés pour correspondre au formulaire
        $data['condition_reglement'] = $data['condition_reglement_id'] ?? null;
        $data['mode_reglement'] = $data['mode_reglement_id'] ?? null;

        return $data;
    }

    protected function getInfoBodaac()
    {
        return app(Siren::class)->call($this->tiers->siren);
    }

    protected function getInfoSchema()
    {
        return [
            Section::make('Information Etablissement')
                ->columns(2)
                ->schema([
                    TextEntry::make('information.uniteLegale.siren')

                ])
        ];
    }

    public function render()
    {
        return view('livewire.tiers.show-tiers');
    }
}
