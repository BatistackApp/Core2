<?php

namespace App\Enums\Flottes;

enum VehiculeType: string
{
    case VEHICLE = 'vehicle'; // Véhicule léger ou utilitaire
    case HEAVY_MACHINERY = 'heavy_machinery'; // Engin de chantier
    case LIGHT_TOOLING = 'light_tooling'; // Outillage léger (ex: pilonneuse)

    /**
     * Retourne le label en français.
     */
    public function label(): string
    {
        return match ($this) {
            self::VEHICLE => 'Véhicule',
            self::HEAVY_MACHINERY => 'Engin de chantier',
            self::LIGHT_TOOLING => 'Outillage léger',
        };
    }
}
