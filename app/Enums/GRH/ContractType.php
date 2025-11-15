<?php

namespace App\Enums\GRH;

enum ContractType: string
{
    case CDI = 'cdi';
    case CDD = 'cdd';
    case INTERIM = 'interim';
    case APPRENTISSAGE = 'apprentissage';

    public function label(): string
    {
        return match ($this) {
            self::CDI => "CDI",
            self::CDD => "CDD",
            self::INTERIM => "Interim",
            self::APPRENTISSAGE => "Apprentissage",
        };
    }
}
