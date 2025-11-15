<div class="flex flex-row gap-10">
    <div class="kt-menu kt-menu-default flex flex-col border border-border rounded-lg w-full max-w-36 py-2" data-kt-tabs="true">
        <div class="kt-menu-item">
            <a class="kt-menu-link kt-tab-toggle active" href="#" data-kt-tab-toggle="#warehouse">
               <span class="kt-menu-title">
                    Entrepot
               </span>
            </a>
        </div>
        <div class="kt-menu-item">
            <a class="kt-menu-link kt-tab-toggle" href="#" data-kt-tab-toggle="#unit">
               <span class="kt-menu-title">
                    Unité
               </span>
            </a>
        </div>
        <div class="kt-menu-item">
            <a class="kt-menu-link kt-tab-toggle" href="#" data-kt-tab-toggle="#categories">
               <span class="kt-menu-title">
                    Catégories
               </span>
            </a>
        </div>
    </div>
    <div class="flex flex-col border border-border rounded-lg w-full p-5">
        <div class="" id="warehouse">
            @livewire("core.component.panel.panel-config-article-warehouse")
        </div>
        <div class="hidden" id="unit">
            Componenent: Unit
        </div>
        <div class="hidden" id="categories">
            Componenent: Catégorie
        </div>
    </div>
</div>
