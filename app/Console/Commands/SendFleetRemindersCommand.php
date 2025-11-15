<?php

namespace App\Console\Commands;

use App\Models\Flottes\VehicleContract;
use App\Models\Flottes\VehicleMaintenance;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendFleetRemindersCommand extends Command
{
    protected $signature = 'fleet:send';

    protected $description = 'Envoie des alertes pour les contrats et maintenances de la flotte arrivant à échéance.';

    public function handle(): void
    {
        $this->info('Vérification des échéances de la flotte...');
        $managers = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->get();

        if ($managers->isEmpty()) {
            $this->warn('Aucun manager de flotte trouvé pour les notifications.');
        }

        // 1. Alertes Contrats (Assurance, CT...)
        // [cite: 2025_11_12_141507_create_vehicle_contracts_table.php]
        $contracts = VehicleContract::whereNotNull('expires_at')
            ->where('expires_at', '<=', now()->addDays(30))
            ->where('expires_at', '>', now())
            ->get();

        foreach ($contracts as $contract) {
            $message = "Le contrat '{$contract->type->label()}' ({$contract->contract_number}) du véhicule '{$contract->vehicule->name}' expire le {$contract->expires_at->format('d/m/Y')}.";
            Notification::send($managers, new FleetReminderNotification($message, $contract->vehicule));
            $this->line($message);
        }

        // 2. Alertes Maintenance préventive planifiée
        // [cite: 2025_11_12_142339_create_vehicle_maintenances_table.php]
        $maintenances = VehicleMaintenance::where('type', 'preventive')
            ->whereNull('completed_at')
            ->whereNotNull('schedule_at')
            ->where('schedule_at', '<=', now()->addDays(7))
            ->get();

        foreach ($maintenances as $maintenance) {
            $message = "La maintenance préventive '{$maintenance->description}' pour '{$maintenance->vehicule->name}' est planifiée le {$maintenance->schedule_at->format('d/m/Y')}.";
            Notification::send($managers, new FleetReminderNotification($message, $maintenance->vehicule));
            $this->line($message);
        }
    }
}
