<?php

namespace App\Livewire\Core\Component\Panel;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Livewire\Component;

class ProfilGeneralPanel extends Component implements HasSchemas, HasActions
{
    use InteractsWithSchemas, InteractsWithActions;


    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.core.component.panel.profil-general-panel');
    }
}
