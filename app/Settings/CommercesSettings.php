<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class CommercesSettings extends Settings
{
    public float $default_vat_rate; // Taux de TVA par défaut
    public string $devis_prefix; // Préfixe (ex: "FA-")
    public int $devis_day_retention;
    public string|null $cvg;
    public static function group(): string
    {
        return 'Commerces';
    }
}
