<?php

namespace App\Enums\Locations;

enum RentalPriceUnit: string
{
    case HOUR = 'hour';
    case DAY = 'day';
    case WEEK = 'week';
    case MONTH = 'month';

    /**
     * Retourne le label en français.
     */
    public function label(): string
    {
        return match ($this) {
            self::HOUR => 'Par heure',
            self::DAY => 'Par jour',
            self::WEEK => 'Par semaine',
            self::MONTH => 'Par mois',
        };
    }
}
