<?php

namespace App\Enums\Commerces;

enum TypeDevisLigne: string
{
    case PRODUCT = 'product';
    case SERVICE = 'service';
    case FABRICATION = 'fabrication';

    public function label(): string
    {
        return match ($this) {
            self::PRODUCT => 'Produit',
            self::SERVICE => 'Service',
            self::FABRICATION => 'Fabrication',
        };
    }
}
