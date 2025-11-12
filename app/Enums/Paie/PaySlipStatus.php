<?php

namespace App\Enums\Paie;
/**
 * Définit le cycle de vie d'un bulletin de paie.
 * Utilisé dans PaySlip->status.
 * [cite: modules/Paie/architecture.md]
 */
enum PaySlipStatus: string
{
    case DRAFT = 'draft'; // Brouillon, en cours de saisie
    case CALCULATED = 'calculated'; // Calculé, en attente de vérification
    case VALIDATED = 'validated'; // Vérifié et validé, ne peut plus être modifié
    case PAID = 'paid'; // Paiement effectué
    case ARCHIVED = 'archived'; // Clôturé

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Brouillon',
            self::CALCULATED => 'Calculé',
            self::VALIDATED => 'Vérifié et validé',
            self::PAID => 'Paiement Effectué',
            self::ARCHIVED => 'Clôturé'
        };
    }
}
