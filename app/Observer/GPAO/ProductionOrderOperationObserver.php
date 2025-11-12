<?php

namespace App\Observer\GPAO;

use App\Jobs\GPAO\UpdateProductionOrderActualCostJob;
use App\Models\GPAO\ProductionOrderOperation;

class ProductionOrderOperationObserver
{
    public function saved(ProductionOrderOperation $operation): void
    {
        // Si le temps passé ou le coût horaire a changé
        if ($operation->wasChanged('time_spent_hours') || $operation->wasChanged('hourly_cost')) {
            // On recalcule le coût total de l'OF parent
            UpdateProductionOrderActualCostJob::dispatch($operation->productionOrder);
        }
    }

    public function deleted(ProductionOrderOperation $operation): void
    {
        if ($operation->productionOrder) {
            UpdateProductionOrderActualCostJob::dispatch($operation->productionOrder);
        }
    }
}
