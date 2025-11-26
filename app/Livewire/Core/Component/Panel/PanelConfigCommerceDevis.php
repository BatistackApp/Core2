<?php

namespace App\Livewire\Core\Component\Panel;

use App\Settings\CommercesSettings;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;

class PanelConfigCommerceDevis extends Component implements HasSchemas, HasActions
{
    use InteractsWithSchemas, InteractsWithActions;

    public ?array $data = [];

    public function mount()
    {
        $settings = app(CommercesSettings::class);
        $this->form->fill([
            'default_vat_rate' => $settings->default_vat_rate,
            'devis_prefix' => $settings->devis_prefix,
            'devis_day_retention' => $settings->devis_day_retention,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                TextInput::make('default_vat_rate')
                    ->label("Taux de TVA par defaut")
                    ->required(),

                TextInput::make('devis_prefix')
                    ->label("Préfixe des devis")
                    ->required(),

                TextInput::make('devis_day_retention')
                    ->label("Nb de jours d'échéance par défaut")
                    ->required(),
            ]);
    }

    public function updateCommerceSettings(): void
    {
        $data = $this->form->getState();
        $settings = app(CommercesSettings::class);

        $settings->default_vat_rate = $data['default_vat_rate'];
        $settings->devis_prefix = $data['devis_prefix'];
        $settings->devis_day_retention = $data['devis_day_retention'];

        $settings->save();

        Notification::make()
            ->success()->title("Mise à jour réussi")
            ->send();
    }

    public function render()
    {
        return view('livewire.core.component.panel.panel-config-commerce-devis');
    }
}
