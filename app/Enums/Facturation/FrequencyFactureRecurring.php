<?php

namespace App\Enums\Facturation;

enum FrequencyFactureRecurring: string
{
    case MONTHLY = 'monthly';
    case QUARTERLY = 'quarterly';
    case YEARLY = 'yearly';

    public function label(): string
    {
        return match ($this) {
            self::MONTHLY => 'Mensuel',
            self::QUARTERLY => 'Trimestriel',
            self::YEARLY => 'Annuel',
        };
    }
}
