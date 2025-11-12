<?php

namespace App\Observer\Tiers;

use App\Models\Tiers\TiersBank;

class TiersBankObserver
{
    public function saving(TiersBank $tiersBank): void
    {
        // [cite: TiersBank.php]
        // On vérifie si le champ 'default' est en cours de modification
        // et s'il est défini sur VRAI.
        if ($tiersBank->isDirty('default') && $tiersBank->default === true) {

            // On met tous les *autres* comptes bancaires de ce Tiers
            // à 'default = false'.
            TiersBank::where('tiers_id', $tiersBank->tiers_id)
                ->where('id', '!=', $tiersBank->id)
                ->update(['default' => false]);
        }
    }
}
