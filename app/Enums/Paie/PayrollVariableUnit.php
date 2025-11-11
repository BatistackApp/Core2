<?php

namespace App\Enums\Paie;
/**
 * Définit les unités pour les variables de paie mensuelles.
 * Utilisé dans PayrollVariable->unit.
 * [cite: modules/Paie/architecture.md]
 */
enum PayrollVariableUnit: string
{
    case AMOUNT = 'amount'; // Valeur monétaire (ex: 150€)
    case HOURS = 'hours'; // Valeur en heures (ex: 10h sup)
    case DAYS = 'days'; // Valeur en jours (ex: 2j absence)

    public function label(): string
    {
        return match ($this) {
            self::AMOUNT => 'Montant',
            self::HOURS => 'Heures',
            self::DAYS => 'Jours',
        };
    }
}
