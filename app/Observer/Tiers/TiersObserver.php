<?php

namespace App\Observer\Tiers;

use App\Enums\Tiers\TiersNature;
use App\Models\Tiers\Tiers;

class TiersObserver
{
    public function creating(Tiers $tiers): void
    {
        // On génère le code_tiers uniquement s'il n'est pas déjà défini
        if (empty($tiers->code_tiers)) {

            // On récupère le dernier ID pour assurer l'incrémentation
            // [cite: Tiers.php]
            $lastId = Tiers::max('id') ?? 0;
            $nextId = $lastId + 1;

            // [cite: TiersNature.php]
            if ($tiers->nature === TiersNature::Client) {
                $prefix = 'CLT' . now()->year . '-';
                $tiers->code_tiers = $prefix . $nextId;
            } elseif ($tiers->nature === TiersNature::Fournisseur) {
                $prefix = 'FOUR' . now()->year . '-';
                $tiers->code_tiers = $prefix . $nextId;
            }
        }
    }

    /**
     * Gérer l'événement "created" (après la création).
     *
     * NOTE: La création des profils (Customer/Supply) n'est PAS
     * gérée ici car elle nécessite des données (comptes comptables, etc.)
     * [cite: 2025_11_09_200620_create_tiers_customers_table.php, 2025_11_09_200240_create_tiers_supplies_table.php]
     * qui doivent provenir du formulaire de création principal.
     */
    public function created(Tiers $tiers): void
    {
    }
}
