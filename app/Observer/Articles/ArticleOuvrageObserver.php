<?php

namespace App\Observer\Articles;

use App\Jobs\Articles\UpdateOuvrageCostPriceJob;
use App\Models\Articles\ArticleOuvrage;

class ArticleOuvrageObserver
{
    public function saved(ArticleOuvrage $articleOuvrage): void
    {
        if ($articleOuvrage->parentArticle) {
            // Déclenche le Job de calcul de coût (asynchrone)
            // [cite: app/Jobs/UpdateOuvrageCostPriceJob.php]
            UpdateOuvrageCostPriceJob::dispatch($articleOuvrage->parentArticle);
        }
    }

    public function deleted(ArticleOuvrage $articleOuvrage): void
    {
        if ($articleOuvrage->parentArticle) {
            // Déclenche le Job de calcul de coût (asynchrone)
            // [cite: app/Jobs/UpdateOuvrageCostPriceJob.php]
            UpdateOuvrageCostPriceJob::dispatch($articleOuvrage->parentArticle);
        }
    }
}
