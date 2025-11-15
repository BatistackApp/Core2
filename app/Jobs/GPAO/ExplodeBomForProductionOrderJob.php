<?php

namespace App\Jobs\GPAO;

use App\Models\GPAO\ProductionOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class ExplodeBomForProductionOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly ProductionOrder $productionOrder)
    {
    }

    public function handle(): void
    {
        $articleToProduce = $this->productionOrder->article;
        $quantityToProduce = $this->productionOrder->quantity_to_produce;

        if ($articleToProduce->type !== 'compound') {
            Log::warning("OF {$this->productionOrder->number}: L'article {$articleToProduce->reference} n'est pas un 'compound' (ouvrage).");
            return;
        }

        $bomComponents = $articleToProduce->components;

        if ($bomComponents->isEmpty()) {
            Log::warning("OF {$this->productionOrder->number}: L'article {$articleToProduce->reference} n'a pas de nomenclature (BOM).");
            return;
        }

        foreach ($bomComponents as $bomComponent) {
            // [cite: app/Models/ProductionOrderComponent.php]
            $this->productionOrder->components()->create([
                'article_id' => $bomComponent->child_article_id,
                'quantity_required' => $bomComponent->quantity * $quantityToProduce,
                'quantity_consumed' => 0,
                // [cite: app/Models/Article.php]
                'unit_cost' => $bomComponent->childArticle->purchase_price_excl_tax ?? 0, // Snapshot du coût
            ]);
        }
    }
}
