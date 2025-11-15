<div class="p-4 sm:p-6 lg:p-8">
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                <span class="text-gray-400 dark:text-gray-500">Article:</span>
                {{ $article->name }}
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Référence: {{ $article->reference }}
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
    <div class="kt-tabs kt-tabs-line" data-kt-tabs="true">
        <button class="kt-tab-toggle active" data-kt-tab-toggle="#general">Générale</button>
        <button class="kt-tab-toggle" data-kt-tab-toggle="#price">Prix</button>
        @if($article->is_stock_managed)
        <button class="kt-tab-toggle" data-kt-tab-toggle="#stock">Stock</button>
        @endif
        @if($article->type_article === \App\Enums\Articles\ArticleType::OUVRAGE)
            <button class="kt-tab-toggle" data-kt-tab-toggle="#ouvrage">Ouvrage</button>
        @endif
    </div>
    <div class="text-sm mt-5">
        <div class="" id="general">
            {{ $this->articleInfolist }}
        </div>
        <div class="hidden" id="price">
            @livewire("articles.panels.article-prices", ['article' => $article])
        </div>
        <div class="hidden" id="stock">
        </div>
        <div class="hidden" id="ouvrage">
        </div>
    </div>
    <x-filament-actions::modals />
</div>
