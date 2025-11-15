<?php

namespace App\Observer\Flottes;

use App\Jobs\Chantiers\UpdateChantierActualCostJob;
use App\Models\Flottes\VehicleTollLog;

class VehicleTollLogObserver
{
    public function created(VehicleTollLog $tollLog): void
    {
        // Si le log est affecté à un chantier, on impute le coût
        if ($tollLog->chantiers_id && $tollLog->amount) {
            // On déporte le calcul dans un Job pour ne pas ralentir l'import API
            UpdateChantierActualCostJob::dispatch(
                $tollLog->chantiers_id,
                $tollLog->amount,
                'toll' // Type de coût
            );
        }
    }
}
