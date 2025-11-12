<?php

namespace App\Enums\Flottes;

enum VehicleMaintenanceType: string
{
    case PREVENTIVE = 'preventive'; // Entretien préventif
    case CORRECTIVE = 'corrective'; // Réparation

    /**
     * Retourne le label en français.
     */
    public function label(): string
    {
        return match ($this) {
            self::PREVENTIVE => 'Préventive',
            self::CORRECTIVE => 'Corrective',
        };
    }

    /**
     * Retourne la couleur (pour l'UI).
     */
    public function color(): string
    {
        return match ($this) {
            self::PREVENTIVE => 'primary',
            self::CORRECTIVE => 'warning',
        };
    }

    /**
     * Retourne une icône Heroicon (pour l'UI).
     */
    public function icon(): string
    {
        return match ($this) {
            self::PREVENTIVE => 'heroicon-o-sparkles',
            self::CORRECTIVE => 'heroicon-o-wrench',
        };
    }
}
