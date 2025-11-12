<?php

namespace App\Observer\GPAO;

use App\Jobs\GPAO\UpdateProductionOrderActualCostJob;
use App\Models\GPAO\ProductionOrderComponent;

class ProductionOrderComponentObserver
{
    public function saved(ProductionOrderComponent $component): void
    {
        // Si la quantité consommée ou le coût a changé
        if ($component->wasChanged('quantity_consumed') || $component->wasChanged('unit_cost')) {
            // On recalcule le coût total de l'OF parent
            UpdateProductionOrderActualCostJob::dispatch($component->productionOrder);
        }
    }

    public function deleted(ProductionOrderComponent $component): void
    {
        if ($component->productionOrder) {
            UpdateProductionOrderActualCostJob::dispatch($component->productionOrder);
        }
    }
}
