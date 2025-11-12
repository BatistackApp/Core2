<?php

namespace App\Enums\Locations;

enum RentalBillingFrequency: string
{
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case ON_TIME = 'on_time';

    /**
     * Retourne le label en français.
     */
    public function label(): string
    {
        return match ($this) {
            self::DAILY => 'Journalière',
            self::WEEKLY => 'Hebdomadaire',
            self::MONTHLY => 'Mensuelle',
            self::ON_TIME => 'En une fois',
        };
    }
}
