<div>
    {{-- En-tête de page --}}
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="sm:flex sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    <span class="text-gray-400 dark:text-gray-500">Tiers:</span>
                    {{ $tiers->name }}
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Fiche détaillée, adresses, contacts et informations bancaires.
                </p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16">
                {{-- Affiche les actions du header (ex: Bouton "Modifier" et "Retour") --}}
                <div class="fi-actions flex flex-wrap items-center gap-3">
                    @foreach ($this->getHeaderActions() as $action)
                        {{ $action }}
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Affiche l'Infolist (les détails en lecture seule) --}}
        {{ $this->tiersInfolist }}

        {{--
          Section pour les composants de relation (Tables Adresses, Contacts, etc.)
          Nous utilisons des composants Livewire séparés pour cela.
        --}}
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- Composant pour les Adresses --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Adresses</h3>
                </div>
                <div class="border-t border-gray-200 dark:border-white/10">
                    @livewire('tiers.panels.tiers-addresses', ['tiers' => $tiers])
                </div>
            </div>

            {{-- Composant pour les Contacts --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Contacts</h3>
                </div>
                <div class="border-t border-gray-200 dark:border-white/10">
                    @livewire('tiers.panels.tiers-contacts', ['tiers' => $tiers])
                </div>
            </div>

            {{-- Composant pour les Banques --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl lg:col-span-2">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Comptes Bancaires</h3>
                </div>
                <div class="border-t border-gray-200 dark:border-white/10">
                    @livewire('tiers.panels.tiers-bank', ['tiers' => $tiers])
                </div>
            </div>

        </div>

    </div>

    {{-- Indispensable pour les modales d'action (comme "Modifier") --}}
    <x-filament-actions::modals />
</div>
