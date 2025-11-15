<?php

namespace App\Enums\Facturation;

enum StatusFactureReccuring: string
{
    case ACTIVE = 'active';
    case PAUSED = 'paused';
    case FINISHED = 'finished';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => "Actif",
            self::PAUSED => "En pause",
            self::FINISHED => "Terminer",
            self::CANCELLED => "Annuler",
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'primary',
            self::PAUSED => 'warning',
            self::FINISHED => 'success',
            self::CANCELLED => 'destructive',
        };
    }
}
