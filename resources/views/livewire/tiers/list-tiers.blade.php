<div class="kt-container-fluid">
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Annuaire des Tiers
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Gérez vos clients, fournisseurs et autres contacts.
            </p>
        </div>
    </div>

    {{ $this->table }}

    {{-- INDISPENSABLE pour que les modales (création/édition) fonctionnent --}}
    <x-filament-actions::modals />
</div>
