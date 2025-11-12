<?php

namespace App\Observer\Locations;

use App\Models\Locations\RentalContract;
use App\Models\Locations\RentalContractLine;
use DB;

class RentalContractLineObserver
{
    public function saved(RentalContractLine $line): void
    {
        $this->updateContractTotal($line->rentalContract);
    }

    public function deleted(RentalContractLine $line): void
    {
        if ($line->rentalContract) {
            $this->updateContractTotal($line->rentalContract);
        }
    }

    /**
     * Recalcule le total du contrat parent.
     */
    protected function updateContractTotal(RentalContract $contract): void
    {
        // [cite: 2025_11_12_151430_create_rental_contract_lines_table.php]
        $total = $contract->lines()
            ->sum(DB::raw('total_line_amount')); // Assure-toi que ce champ est bien calculé sur la ligne

        // [cite: 2025_11_12_151054_create_rental_contracts_table.php]
        $contract->total_amount = $total ?? 0;

        $contract->saveQuietly();
    }
}
