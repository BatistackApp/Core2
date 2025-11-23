<div class="kt-container-fluid">
    <div class="grid grid-cols-2 gap-5 pb-5">
        <div class="flex flex-col gap-5">
            @livewire('commerces.widget.devis-chart')
            @livewire('commerces.widget.commande-chart')

        </div>
        <div class="flex flex-col gap-5">
            @livewire('commerces.widget.latest-tiers')
            @livewire('commerces.widget.devis-draft')
            @livewire('commerces.widget.commande-draft')
        </div>
    </div>
</div>
