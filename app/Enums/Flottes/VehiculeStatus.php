<?php

namespace App\Enums\Flottes;

enum VehiculeStatus: string
{
    case ACTIVE = 'active'; // En service
    case IN_MAINTENANCE = 'in_maintenance'; // En maintenance
    case SOLD = 'sold'; // Vendu
    case STOLEN = 'stolen'; // Volé

    /**
     * Retourne le label en français.
     */
    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Actif',
            self::IN_MAINTENANCE => 'En maintenance',
            self::SOLD => 'Vendu',
            self::STOLEN => 'Volé',
        };
    }

    /**
     * Retourne la couleur (pour l'UI).
     */
    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::IN_MAINTENANCE => 'warning',
            self::SOLD => 'mono',
            self::STOLEN => 'destructive',
        };
    }

    /**
     * Retourne une icône Heroicon (pour l'UI).
     */
    public function icon(): string
    {
        return match ($this) {
            self::ACTIVE => 'heroicon-o-check-circle',
            self::IN_MAINTENANCE => 'heroicon-o-clock',
            self::SOLD => 'heroicon-o-currency-euro',
            self::STOLEN => 'heroicon-o-exclamation-triangle',
        };
    }
}
