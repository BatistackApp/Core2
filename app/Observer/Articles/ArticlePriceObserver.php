<?php

namespace App\Observer\Articles;

use App\Enums\Tiers\TiersNature;
use App\Models\Articles\ArticlePrice;

class ArticlePriceObserver
{
    public function updated(ArticlePrice $articlePrice): void
    {
        if ($articlePrice->type_price === 'achat') {
            $articlePrice->articles->update([
                'price_achat_ht' => $articlePrice->price_ht
            ]);
        } else {
            $articlePrice->articles->update([
                'prix_vente_ht' => $articlePrice->price_ht
            ]);
        }
    }

    public function saved(ArticlePrice $articlePrice): void
    {
        if ($articlePrice->type_price === 'achat') {
            $articlePrice->articles->update([
                'price_achat_ht' => $articlePrice->price_ht
            ]);
        } else {
            $articlePrice->articles->update([
                'prix_vente_ht' => $articlePrice->price_ht
            ]);
        }
    }

    public function deleted(ArticlePrice $articlePrice): void
    {
        if ($articlePrice->type_price === 'achat') {
            $articlePrice->articles->update([
                'price_achat_ht' => null
            ]);
        } else {
            $articlePrice->articles->update([
                'prix_vente_ht' => null
            ]);
        }
    }
}
