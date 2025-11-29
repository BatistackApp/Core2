<div class="kt-container-fluid">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                Détail du devis
            </h1>
        </div>
        <div class="flex items-center gap-2.5">
            <a class="kt-btn kt-btn-outline" href="{{ route('commerces.devis.liste') }}">
                <i class="ki-filled ki-arrow-circle-left">
                </i>
                Retour aux devis
            </a>
        </div>
    </div>
    <div class="flex flex-row gap-5 mb-10">
        <div class="kt-card w-1/2 h-full">
            <div class="kt-card-header">
                <h1 class="kt-card-title">Détails du Devis (#{{ $this->devis->num_devis }})</h1>
            </div>
            <div class="kt-card-content">
                <div class="flex flex-col p-5 gap-4">
                    <div class="flex justify-between items-center">
                        <div class="font-medium">
                            <i class="ki-duotone ki-calendar-8 me-2"></i>
                            <span>Date du devis</span>
                        </div>
                        <span>{{ $this->devis->date_devis->format('d/m/Y') }}</span>
                    </div>
                    <div class="kt-separator my-2"></div>
                    <div class="flex justify-between items-center">
                        <div class="font-medium">
                            <i class="ki-duotone ki-calendar-2 me-2"></i>
                            <span>Validité du devis</span>
                        </div>
                        <div class="flex flex-col gap-1 justify-end items-end">
                            <span>{{ $this->devis->date_devis->addDays(app(\App\Settings\CommercesSettings::class)->devis_day_retention)->format('d/m/Y') }}</span>
                            <span class="kt-badge kt-badge-info ms-2">
                                Expire {{ $this->devis->date_devis->addDays(app(\App\Settings\CommercesSettings::class)->devis_day_retention)->longRelativeDiffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <div class="kt-separator my-2"></div>
                    <div class="flex justify-between items-center">
                        <div class="font-medium">
                            <i class="ki-duotone ki-status me-2"></i>
                            <span>Etat du devis</span>
                        </div>
                        <span class="kt-badge kt-badge-{{ $this->devis->status->color() }}">{{ $this->devis->status->label() }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-card w-1/2 h-full">
            <div class="kt-card-header">
                <h1 class="kt-card-title">Tiers ({{ $this->devis->tiers->nature->label() }})</h1>
            </div>
            <div class="kt-card-content">
                <div class="flex flex-col p-5 gap-4">
                    <div class="flex justify-between items-center">
                        <div class="font-medium">
                            <i class="ki-duotone ki-user me-2"></i>
                            <span>Tiers</span>
                        </div>
                        <a href="{{ route('tiers.show', $this->devis->tiers) }}">{{ $this->devis->tiers->name }}</a>
                    </div>
                    <div class="kt-separator my-2"></div>
                    <div class="flex justify-between items-center">
                        <div class="font-medium">
                            <i class="ki-duotone ki-sms me-2"></i>
                            <span>Email</span>
                        </div>
                        <span>{{ $this->devis->tiers->contacts()->first()->email ?? 'Aucun contact définie' }}</span>
                    </div>
                    <div class="kt-separator my-2"></div>
                    <div class="flex justify-between items-center">
                        <div class="font-medium">
                            <i class="ki-duotone ki-phone me-2"></i>
                            <span>Téléphone</span>
                        </div>
                        <span>{{ $this->devis->tiers->contacts()->first()->tel ?? 'Aucun contact définie' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ $this->table }}
    <div class="flex flex-row justify-end mt-10">
        <div class="kt-card w-[450px] h-full">
            <div class="kt-card-content">
                <div class="flex flex-col p-5 gap-4">
                    <div class="flex justify-between items-center">
                        <div class="font-medium">
                            <span>Total HT</span>
                        </div>
                        <span>{{ Number::currency($this->devis->amount_ht, 'eur', 'fr') }}</span>
                    </div>
                    <div class="kt-separator my-2"></div>
                    <div class="flex justify-between items-center">
                        <div class="font-medium">
                            <span>Total TVA ({{ app(\App\Settings\CommercesSettings::class)->default_vat_rate }}%)</span>
                        </div>
                        <span>{{ Number::currency($this->devis->total_vat, 'eur', 'fr') }}</span>
                    </div>
                    <div class="kt-separator border-b-2 my-2"></div>
                    <div class="flex justify-between items-center font-bold text-xl">
                        <div class="font-medium">
                            <i class="ki-duotone ki-euro me-2"></i>
                            <span>Total TTC</span>
                        </div>
                        <span>{{ Number::currency($this->devis->amount_ttc, 'eur', 'fr') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-filament-actions::modals />
</div>
