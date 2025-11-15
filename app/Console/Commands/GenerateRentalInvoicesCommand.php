<?php

namespace App\Console\Commands;

use App\Enums\Locations\RentalBillingFrequency;
use App\Enums\Locations\RentalContractStatus;
use App\Models\Facturation\Facture;
use App\Models\Facturation\FactureLigne;
use App\Models\Locations\RentalContract;
use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Log;

class GenerateRentalInvoicesCommand extends Command
{
    protected $signature = 'rental:generate';

    protected $description = 'Génère automatiquement les factures pour les contrats de location actifs.';

    public function handle(): void
    {
        $this->info('Démarrage de la génération des factures de location...');
        $now = Carbon::now();

        $contractsToBill = RentalContract::where('status', RentalContractStatus::ACTIVE)
            ->get()
            ->filter(function ($contract) use ($now) {
                return $this->isBillingDue($contract, $now);
            });

        if ($contractsToBill->isEmpty()) {
            $this->info('Aucun contrat à facturer.');
            return;
        }

        foreach ($contractsToBill as $contract) {
            $this->line("Facturation du contrat: {$contract->number}");
            try {
                DB::transaction(function () use ($contract, $now) {
                    // 1. Créer l'en-tête de la facture
                    // [cite: modules/Facturations/architecture.md]
                    $invoice = Facture::create([
                        'tiers_id' => $contract->tier_id,
                        'chantiers_id' => $contract->chantiers_id,
                        'number' => 'FA-LOC-' . $contract->number . '-' . $now->format('Ym'), // Logique de numérotation à affiner
                        'status' => 'draft',
                        'type' => 'standard',
                        'issued_at' => $now,
                        'due_at' => $now->addDays(30),
                        // ... Remplir les autres champs requis par le module Facturation
                    ]);

                    // 2. Copier les lignes
                    foreach ($contract->lines as $line) {
                        FactureLigne::create([
                            'facture_id' => $invoice->id,
                            'articles_id' => ($line->rentable_type === 'App\Models\Article') ? $line->rentable_id : null,
                            'description' => $line->description,
                            'quantity' => 1, // Facturation pour la période
                            'unit' => $line->price_unit->label(),
                            'unit_price_excl_tax' => $line->total_line_amount, // Simplification: on facture le total de la ligne du contrat
                            // ... Remplir les autres champs (TVA, totaux)
                        ]);
                    }

                    // 3. Mettre à jour le contrat
                    $contract->last_billed_at = $now->toDateString();
                    $contract->save();

                    // 4. (Optionnel) Mettre à jour les totaux de la facture via un Observer
                });
                $this->info("Facture créée pour le contrat: {$contract->number}");

            } catch (\Exception $e) {
                Log::error("Échec de facturation pour contrat {$contract->id}: " . $e->getMessage());
                $this->error("Échec pour le contrat: {$contract->number}");
            }
        }
        $this->info('Génération terminée.');
        return;
    }

    /**
     * Vérifie si un contrat doit être facturé.
     */
    protected function isBillingDue(RentalContract $contract, Carbon $now): bool
    {
        $frequency = $contract->billing_frequency;
        $lastBilled = $contract->last_billed_at;

        if ($frequency === RentalBillingFrequency::ON_TIME) {
            return $lastBilled === null;
        }

        if ($lastBilled === null) {
            return true; // Première facturation
        }

        $lastBilledDate = Carbon::parse($lastBilled);

        return match ($frequency) {
            RentalBillingFrequency::DAILY => $lastBilledDate->lessThan($now->startOfDay()),
            RentalBillingFrequency::WEEKLY => $lastBilledDate->lessThan($now->subWeek()),
            RentalBillingFrequency::MONTHLY => $lastBilledDate->lessThan($now->subMonth()),
            default => false,
        };
    }
}
