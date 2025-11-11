<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class FacturationSettings extends Settings
{
    public float $default_vat_rate = 20.0; // Taux de TVA par défaut
    public float $default_guarantee_retention_percentage = 0; // Taux de RG par défaut
    public string $invoice_prefix = 'FA-'; // Préfixe (ex: "FA-")
    public int $invoice_next_number = 1; // Prochain numéro de facture
    public int $days_before_due = 0; // Nb de jours d'échéance par défaut

    public static function group(): string
    {
        return 'Facturation';
    }
}
