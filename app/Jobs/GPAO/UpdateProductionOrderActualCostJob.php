<?php

namespace App\Jobs\GPAO;

use App\Models\GPAO\ProductionOrder;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateProductionOrderActualCostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public ProductionOrder $productionOrder)
    {
    }

    public function handle(): void
    {
        // 1. Coût des composants (Matériaux)
        // [cite: app/Models/ProductionOrderComponent.php]
        $totalComponentCost = $this->productionOrder->components()
            ->select(DB::raw('SUM(quantity_consumed * unit_cost) as total'))
            ->value('total');

        // 2. Coût des opérations (Main d'œuvre)
        // [cite: app/Models/ProductionOrderOperation.php]
        $totalOperationCost = $this->productionOrder->operations()
            ->select(DB::raw('SUM(time_spent_hours * hourly_cost) as total'))
            ->value('total');

        // 3. Mise à jour de l'OF
        // [cite: app/Models/ProductionOrder.php]
        $this->productionOrder->update([
            'actual_cost' => ($totalComponentCost ?? 0) + ($totalOperationCost ?? 0)
        ]);
    }
}
