<?php

namespace App\Console\Commands;

use App\Models\Articles\Articles;
use App\Models\User;
use App\Notifications\Articles\StockAlertNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class CheckStockAlertsCommand extends Command
{
    protected $signature = 'stock:check';

    protected $description = "Vérifie les seuils de stock et envoie un rapport d'alerte.";

    public function handle(): void
    {
        $this->info('Vérification des seuils de stock...');

        // 1. Trouver les utilisateurs à notifier (Simplification)
        $usersToNotify = User::where('role', 'admin')->get(); // À adapter

        if ($usersToNotify->isEmpty()) {
            $this->warn('Aucun utilisateur trouvé pour la notification. Arrêt.');
            return;
        }

        // 2. Trouver les articles gérés en stock avec un seuil
        $articlesToMonitor = Articles::where('is_stock_managed', true)
            ->whereNotNull('stock_alert_threshold')
            ->with('stocks') // Pré-charge la relation de stock
            ->get();

        $lowStockCount = 0;

        foreach ($articlesToMonitor as $article) {
            $totalStock = $article->stocks->sum('quantity');

            if ($totalStock <= $article->stock_alert_threshold) {

                // TODO: Ajouter la logique de "debounce" (Notification unique)
                // de l'ArticleStockObserver [cite: app/Observers/Articles/ArticleStockObserver.php]
                // pour éviter de notifier 2x (temps réel + rapport)

                $this->line("- Alerte: {$article->name} (Stock: {$totalStock} / Seuil: {$article->stock_alert_threshold})");

                // Envoyer la notification
                Notification::send($usersToNotify, new StockAlertNotification($article, $totalStock));
                $lowStockCount++;
            }
        }
    }
}
