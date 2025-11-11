<?php

namespace App\Enums\Banque;

enum TypeBanqueAccount: string
{
    case COMPTE = 'compte';
    case CAISSE = 'caisse';

    public function label(): string
    {
        return match ($this) {
            self::COMPTE => 'Compte',
            self::CAISSE => 'Caisse',
        };
    }
}
