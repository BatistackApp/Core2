<?php

namespace App\Enums\Flottes;

enum VehicleCostFrequency: string
{
    case MONTHLY = 'monthly'; // Mensuel
    case ANNUALLY = 'annually'; // Annuel
    case ON_TIME = 'on_time'; // Ponctuel (ex: contrôle technique)

    /**
     * Retourne le label en français.
     */
    public function label(): string
    {
        return match ($this) {
            self::MONTHLY => 'Mensuel',
            self::ANNUALLY => 'Annuel',
            self::ON_TIME => 'Ponctuel',
        };
    }
}
