<div>
    <div class="p-4 sm:p-6 lg:p-8">
        {{-- En-tête de page --}}
        <div class="sm:flex sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Articles & Ouvrages
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Gérez votre catalogue de produits, services et ouvrages composés.
                </p>
            </div>
        </div>

        {{-- Affiche la table, filtres, pagination, et modales d'actions --}}
        {{ $this->table }}

        {{-- Indispensable pour les modales (création/édition) --}}
        <x-filament-actions::modals />
    </div>
</div>
