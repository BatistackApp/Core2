<?php

namespace App\Livewire\Core;

use App\Models\Core\Service;
use App\Services\Batistack;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.base')]
#[Title("Ma License")]
class License extends Component
{
    public $license;

    public function mount()
    {
        if(!auth()->user()->isAdmin) {
            abort(401);
        }
        $this->license = app(Batistack::class)->get('/license/info', ['license_key' => Service::first()->service_code]);
    }
    public function render()
    {
        //dd($this->license);
        return view('livewire.core.license');
    }
}
