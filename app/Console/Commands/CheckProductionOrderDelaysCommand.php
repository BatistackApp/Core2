<?php

namespace App\Console\Commands;

use App\Enums\GPAO\ProductionOrderStatus;
use App\Models\GPAO\ProductionOrder;
use App\Notifications\GPAO\ProductionOrderDueSoonNotification;
use Illuminate\Console\Command;
use Notification;

class CheckProductionOrderDelaysCommand extends Command
{
    protected $signature = 'production:check';

    protected $description = "Vérifie les OF en cours qui approchent de leur date d'échéance.";

    public function handle(): void
    {
        $this->info('Vérification des délais des Ordres de Fabrication...');

        $ordersDueSoon = ProductionOrder::where('status', ProductionOrderStatus::IN_PROGRESS)
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(3))
            ->get();

        if ($ordersDueSoon->isEmpty()) {
            $this->info('Aucun OF en retard ou en alerte.');
        }

        foreach ($ordersDueSoon as $order) {
            // [cite: app/Models/ProductionOrder.php]
            $this->line('Alerte: OF ' . $order->number . ' arrive à échéance le ' . $order->due_date->format('d/m/Y'));

            // Envoyer une notification au responsable du chantier ou de l'OF
            if ($order->chantier && $order->chantier->user) {
                Notification::send($order->chantier->user, new ProductionOrderDueSoonNotification($order));
            }
        }

        $this->info('Terminé.');
    }
}
