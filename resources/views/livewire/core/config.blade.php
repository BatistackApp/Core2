<div class="kt-container-fixed">
    <div class="space-y-3 space-x-3">
        <div class="kt-tabs kt-tabs-line" data-kt-tabs="true">
            <button class="kt-tab-toggle active" data-kt-tab-toggle="#entreprise">Mon Entreprise</button>
            <button class="kt-tab-toggle" data-kt-tab-toggle="#modules">Mes Modules</button>
            <button class="kt-tab-toggle" data-kt-tab-toggle="#config-article">Articles (Configuration)</button>
            <button class="kt-tab-toggle" data-kt-tab-toggle="#config-commerces">Commerces (Configuration)</button>
        </div>
        <div class="text-sm">
            <div id="entreprise" class="">
                <livewire:core.config-company />
            </div>
            <div id="modules" class="hidden">
                <livewire:core.config-module />
            </div>
            <div id="config-article" class="hidden">
                @livewire('core.component.panel.panel-config-article')
            </div>
            <div id="config-commerces" class="hidden">
                @livewire('core.component.panel.panel-config-commerce')
            </div>
        </div>
    </div>
</div>
