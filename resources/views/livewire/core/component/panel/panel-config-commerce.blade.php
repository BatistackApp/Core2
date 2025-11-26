<div class="flex flex-row gap-10">
    <div class="kt-menu kt-menu-default flex flex-col border border-border rounded-lg w-full max-w-36 py-2" data-kt-tabs="true">
        <div class="kt-menu-item">
            <a class="kt-menu-link kt-tab-toggle active" href="#" data-kt-tab-toggle="#devis">
               <span class="kt-menu-title">
                    Devis
               </span>
            </a>
        </div>
        <div class="kt-menu-item">
            <a class="kt-menu-link kt-tab-toggle" href="#" data-kt-tab-toggle="#commandes">
               <span class="kt-menu-title">
                    Commandes
               </span>
            </a>
        </div>
    </div>
    <div class="flex flex-col border border-border rounded-lg w-full p-5">
        <div class="" id="devis">
            @livewire("core.component.panel.panel-config-commerce-devis")
        </div>
        <div class="hidden" id="commandes">
            @livewire("core.component.panel.panel-config-commerce-commandes")
        </div>
    </div>
</div>
