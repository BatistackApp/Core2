<?php

namespace App\Observer\GPAO;

use App\Enums\GPAO\ProductionOrderStatus;
use App\Jobs\GPAO\ExplodeBomForProductionOrderJob;
use App\Jobs\GPAO\ReceiveProductionOrderStockJob;
use App\Models\GPAO\ProductionOrder;

/**
 * Observe le modèle ProductionOrder.
 * Gère le déclenchement des actions de workflow (BOM, Réception Stock).
 * [cite: modules/GPAO/architecture.md]
 */
class ProductionOrderObserver
{
    /**
     * Gérer l'événement "updated" (après mise à jour).
     */
    public function updated(ProductionOrder $productionOrder): void
    {
        // Si l'OF passe au statut "Planifié"
        if ($productionOrder->wasChanged('status') && $productionOrder->status === ProductionOrderStatus::PLANNED) {
            // On déclenche le Job pour "exploser" la nomenclature (BOM)
            // [cite: app/Jobs/ExplodeBomForProductionOrderJob.php]
            ExplodeBomForProductionOrderJob::dispatch($productionOrder);
        }

        // Si l'OF passe au statut "Terminé"
        if ($productionOrder->wasChanged('status') && $productionOrder->status === ProductionOrderStatus::COMPLETED) {
            // On déclenche le Job pour réceptionner le produit fini en stock
            // [cite: app/Jobs/ReceiveProductionOrderStockJob.php]
            ReceiveProductionOrderStockJob::dispatch($productionOrder);
            // On pourrait aussi déclencher la sortie de stock des composants ici
        }
    }
}
