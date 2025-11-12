<?php

namespace App\Jobs\Articles;

use App\Enums\Articles\ArticleType;
use App\Models\Articles\Articles;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class UpdateOuvrageCostPriceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Articles $ouvrageArticle)
    {
    }

    public function handle(): void
    {
        if ($this->ouvrageArticle->type_article !== ArticleType::OUVRAGE) {
            Log::warning("UpdateOuvrageCostPriceJob: Tentative de recalcul de coût sur l'article non-ouvrage ID {$this->ouvrageArticle->id}.");
            return;
        }

        $totalCost = 0;

        // On charge les composants (ArticleOuvrage) et leurs enfants (Articles)
        $components = $this->ouvrageArticle->components()->with('childArticle')->get();

        foreach ($components as $component) {
            $childArticle = $component->childArticle;

            if ($childArticle && $childArticle->price_achat_ht !== null) {
                $totalCost += ($childArticle->price_achat_ht * $component->quantity);
            }
        }

        $this->ouvrageArticle->price_achat_ht = $totalCost;
        $this->ouvrageArticle->save();
    }
}
