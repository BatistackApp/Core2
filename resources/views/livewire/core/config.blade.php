<div class="kt-container-fixed">
    <div class="space-y-3 space-x-3">
        <div class="kt-tabs kt-tabs-line" data-kt-tabs="true">
            <button class="kt-tab-toggle active" data-kt-tab-toggle="#entreprise">Mon Entreprise</button>
            <button class="kt-tab-toggle" data-kt-tab-toggle="#modules">Mes Modules</button>
        </div>
        <div class="text-sm">
            <div id="entreprise" class="">
                <livewire:core.config-company />
            </div>
            <div id="modules" class="hidden">
                <livewire:core.config-module />
            </div>
        </div>
    </div>
</div>
