<div class="space-y-3 kt-container-fixed">
    <div class="kt-tabs kt-tabs-line" data-kt-tabs="true">
        <button class="kt-tab-toggle active" data-kt-tab-toggle="#general">Générales</button>
        <button class="kt-tab-toggle" data-kt-tab-toggle="#security">Sécurité</button>
        <button class="kt-tab-toggle" data-kt-tab-toggle="#appareance">Apparences</button>
    </div>
    <div class="text-sm">
        <div class="" id="general">
            @livewire('core.component.panel.profil-general-panel')
        </div>
        <div class="hidden" id="security">
            @livewire('core.component.panel.profil-security-panel')
        </div>
        <div class="hidden" id="appareance">
            @livewire('core.component.panel.profil-appearance-panel')
        </div>
    </div>
</div>
