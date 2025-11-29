<?php

namespace App\Livewire\Core\Component\Panel;

use App\Settings\CommercesSettings;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;

class PanelConfigCvg extends Component implements HasSchemas, HasActions
{
    use InteractsWithActions, InteractsWithSchemas;

    public ?array $data = [];

    public function mount()
    {
        $settings = app(CommercesSettings::class);
        $this->form->fill([
            'cvg' => $settings->cvg,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->model(CommercesSettings::class)
            ->components([
                MarkdownEditor::make('cvg')
                    ->label("Conditions Générales de Vente")
                    ->required(),
            ]);
    }

    public function editCvg()
    {
        $data = $this->form->getState();
        $settings = app(CommercesSettings::class);

        $settings->cvg = $data['cvg'];
        $settings->save();
    }

    public function render()
    {
        return view('livewire.core.component.panel.panel-config-cvg');
    }
}
