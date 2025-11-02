<div>
    <div class="flex items-center flex-wrap md:flex-nowrap lg:items-end justify-between border-b border-b-border gap-3 lg:gap-6 mb-5 lg:mb-10">
        <div class="kt-container-fixed" id="hero-container">
            <div class="grid">
                <div class="kt-scrollable-x-auto">
                    <div class="kt-tabs kt-tabs-line gap-3" data-kt-tabs="true">
                        <button class="kt-tab-toggle active text-lg" data-kt-tab-toggle="general">
                            <i class="ki-duotone ki-user-square pe-1"></i>
                            Générales
                        </button>
                        <button class="kt-tab-toggle text-lg" data-kt-tab-toggle="security">
                            <i class="ki-duotone ki-shield pe-1"></i>
                            Sécurités
                        </button>
                        <button class="kt-tab-toggle text-lg" data-kt-tab-toggle="appearance">
                            <i class="ki-duotone ki-color-swatch pe-1"></i>
                            Apparence
                        </button>
                    </div>
                </div>
            </div>            
        </div>
    </div>
    <div class="" id="general">
        @livewire('core.component.panel.profil-general-panel')
    </div>
    <div class="hidden" id="security">
        @livewire('core.component.panel.profil-security-panel')
    </div>
    <div class="hidden" id="appearance">
        @livewire('core.component.panel.profil-appearance-panel')
    </div>
</div>
