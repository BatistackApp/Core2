<?php

namespace App\Enums\Flottes;

enum VehiculeContractType: string
{
    case INSURANCE = 'insurance'; // Assurance
    case LEASING = 'leasing'; // Location longue durée
    case TECHNICAL_CONTROL = 'technical_control'; // Contrôle technique

    /**
     * Retourne le label en français.
     */
    public function label(): string
    {
        return match ($this) {
            self::INSURANCE => 'Assurance',
            self::LEASING => 'Leasing / Location',
            self::TECHNICAL_CONTROL => 'Contrôle Technique',
        };
    }

    /**
     * Retourne la couleur (pour l'UI).
     */
    public function color(): string
    {
        return match ($this) {
            self::INSURANCE => 'primary',
            self::LEASING => 'warning',
            self::TECHNICAL_CONTROL => 'info',
        };
    }

    /**
     * Retourne une icône Heroicon (pour l'UI).
     */
    public function icon(): string
    {
        return match ($this) {
            self::INSURANCE => 'heroicon-o-shield-check',
            self::LEASING => 'heroicon-o-banknotes',
            self::TECHNICAL_CONTROL => 'heroicon-o-clipboard-document-check',
        };
    }
}
