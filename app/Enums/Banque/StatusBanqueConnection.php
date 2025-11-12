<?php

namespace App\Enums\Banque;

enum StatusBanqueConnection: string
{
    case ACTIVE = "active";
    case DISCONNECTED = "disconnected";
    case ERROR = "error";

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::DISCONNECTED => 'Déconnecter',
            self::ERROR => 'Erreur',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::DISCONNECTED => 'primary',
            self::ERROR => 'destructive',
        };
    }
}
