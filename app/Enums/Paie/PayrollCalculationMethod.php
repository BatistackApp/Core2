<?php

namespace App\Enums\Paie;
/**
 * Définit les méthodes de calcul pour les règles de paie.
 * Utilisé dans PayrollComponent->calculation_method.
 * [cite: modules/Paie/architecture.md]
 */
enum PayrollCalculationMethod: string
{
    case FIXED = 'fixed'; // Montant fixe
    case RATE = 'rate'; // Taux (pourcentage)
    case FORMULA = 'formula'; // Logique de calcul complexe (via un service)
    case VARIABLE = 'variable'; // Entrée manuelle (via PayrollVariable)

    public function label(): string
    {
        return match ($this) {
            self::FIXED => 'Montant fixe',
            self::RATE => 'Taux',
            self::FORMULA => 'Formulaire',
            self::VARIABLE => 'Variable',
        };
    }
}
