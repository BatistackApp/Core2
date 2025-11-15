<?php

namespace App\Observer\Flottes;

use App\Jobs\Chantiers\UpdateChantierActualCostJob;
use App\Models\Flottes\VehicleUsageLog;

class VehicleUsageLogObserver
{
    public function created(VehicleUsageLog $usageLog): void
    {
        if (!$usageLog->chantiers_id) {
            return; // Pas de chantier, pas d'imputation
        }

        // --- Logique de calcul de coût (simplifiée) ---
        // TODO: Externaliser cette logique dans un Service ou un Setting

        $cost = 0;
        $vehicule = $usageLog->vehicule;

        if ($usageLog->mileage_end && $usageLog->mileage_start) {
            $costPerKm = 0.50; // A récupérer des settings
            $km = $usageLog->mileage_end - $usageLog->mileage_start;
            $cost = $km * $costPerKm;
        }
        elseif ($usageLog->hours_end && $usageLog->hours_start) {
            $costPerHour = 75.00; // A récupérer des settings
            $hours = $usageLog->hours_end - $usageLog->hours_start;
            $cost = $hours * $costPerHour;
        }

        if ($cost > 0) {
            UpdateChantierActualCostJob::dispatch(
                $usageLog->chantiers_id,
                $cost,
                'usage' // Type de coût
            );
        }
    }
}
