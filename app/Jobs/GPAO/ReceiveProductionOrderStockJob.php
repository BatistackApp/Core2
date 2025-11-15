<?php

namespace App\Jobs\GPAO;

use App\Models\Articles\ArticleStock;
use App\Models\Core\Warehouse;
use App\Models\GPAO\ProductionOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReceiveProductionOrderStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public ProductionOrder $productionOrder)
    {
    }

    public function handle(): void
    {
        // 1. Récupérer l'article produit
        // [cite: app/Models/ProductionOrder.php]
        $articleProduced = $this->productionOrder->article;

        // 2. Vérifier si l'article gère le stock
        // [cite: app/Models/Article.php]
        if (!$articleProduced->is_stock_managed) {
            return; // Pas de gestion de stock, on s'arrête
        }

        // 3. Trouver l'entrepôt par défaut (simplification)
        // [cite: app/Models/Warehouse.php]
        $defaultWarehouse = Warehouse::where('is_default', true)
            ->firstOrFail();

        // 4. Mettre à jour (ou créer) la ligne de stock
        // [cite: app/Models/ArticleStock.php]
        $stockLine = ArticleStock::firstOrNew([
            'article_id' => $articleProduced->id,
            'warehouse_id' => $defaultWarehouse->id,
        ]);

        // 5. Incrémenter le stock
        $stockLine->quantity += $this->productionOrder->quantity_produced;
        $stockLine->save();
    }
}
