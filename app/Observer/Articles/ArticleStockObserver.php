<?php

namespace App\Observer\Articles;

use App\Models\Articles\ArticleStock;
use App\Models\User;
use App\Notifications\Articles\StockAlertNotification;
use Illuminate\Support\Facades\Notification;

class ArticleStockObserver
{
    public function saved(ArticleStock $articleStock): void
    {
        // On ne fait rien si la quantité n'a pas changé
        if (!$articleStock->wasChanged('quantity')) {
            return;
        }

        // Récupère l'article parent
        // [cite: app/Models/Articles/ArticleStock.php]
        $article = $articleStock->articles;

        // Vérifie si l'article est géré en stock et a un seuil
        // [cite: 2025_11_10_000002_create_articles_table.php]
        if (!$article->is_stock_managed || $article->stock_alert_threshold === null) {
            return;
        }

        // Calcule le stock total (tous entrepôts confondus)
        // [cite: app/Models/Articles/Articles.php]
        $totalStock = $article->stocks()->sum('quantity');

        // Si le stock total est sous le seuil
        if ($totalStock <= $article->stock_alert_threshold) {

            // TODO: Ajouter une logique de "debounce" (ex: ne pas notifier plus d'une fois par jour)
            // (ex: vérifier un champ `last_alert_sent_at` sur l'article)

            // Trouve les utilisateurs à notifier (simplification)
            $usersToNotify = User::where('role', 'admin')->get(); // A adapter

            if ($usersToNotify->isNotEmpty()) {
                // Envoie la notification
                // [cite: app/Notifications/StockAlertNotification.php]
                Notification::send($usersToNotify, new StockAlertNotification($article, $totalStock));
            }
        }
    }
}
