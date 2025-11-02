<div>
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-2xl font-semibold leading-none text-mono mb1.5">
                Configuration de mon entreprise
            </h1>
        </div>
    </div>
    <form wire:submit="updateCompany">
        {{ $this->form }}

        <div class="flex justify-end mt-5">
            <button type="submit" class="kt-btn">Valider</button>
        </div>
    </form>
</div>
