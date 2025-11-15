<?php

namespace App\Observer\Locations;

use App\Enums\Locations\RentalContractStatus;
use App\Models\Locations\RentalAvailability;
use App\Models\Locations\RentalContract;

class RentalContractObserver
{
    public function updated(RentalContract $contract): void
    {
        // Si le contrat vient d'être activé
        if ($contract->wasChanged('status') && $contract->status === RentalContractStatus::ACTIVE) {
            $this->createAvailabilityBookings($contract);
        }

        // Si le contrat est terminé ou annulé
        if ($contract->wasChanged('status') &&
            in_array($contract->status, [RentalContractStatus::COMPLETED, RentalContractStatus::CANCELLED])) {
            $this->removeAvailabilityBookings($contract);
        }
    }

    public function deleted(RentalContract $contract): void
    {
        $this->removeAvailabilityBookings($contract);
    }

    /**
     * Crée les entrées de réservation de disponibilité pour ce contrat.
     * [cite: 2025_11_12_151641_create_rental_availabilities_table.php]
     */
    private function createAvailabilityBookings(RentalContract $contract): void
    {
        // On s'assure qu'il n'y a pas de doublons
        $this->removeAvailabilityBookings($contract);

        foreach ($contract->lines as $line) {
            RentalAvailability::create([
                'rental_contract_id' => $contract->id,
                'rentable_id' => $line->rentable_id,
                'rentable_type' => $line->rentable_type,
                'start_date' => $contract->start_date,
                'end_date' => $contract->end_date,
                'quantity_reserved' => $line->quantity,
            ]);
        }
    }

    /**
     * Supprime les réservations de disponibilité pour ce contrat.
     */
    private function removeAvailabilityBookings(RentalContract $contract): void
    {
        RentalAvailability::where('rental_contract_id', $contract->id)->delete();
    }
}
