<?php

namespace App\Enums\Paie;

enum PayrollComponentType: string
{
    case BASE = 'base'; // Assiette de calcul (ex: Brut)
    case GROSS_EARNING = 'gross_earning'; // Gain (brut)
    case SALARY_DEDUCTION = 'salary_deduction'; // Cotisation salariale (retenue)
    case EMPLOYER_CONTRIBUTION = 'employer_contribution'; // Cotisation patronale
    case NET_EARNING = 'net_earning'; // Net (ex: Net à payer)
    case BENEFIT_IN_KIND = 'benefit_in_kind'; // Avantage en nature

    public function label(): string
    {
        return match ($this) {
            self::BASE => 'Assiette de calcul',
            self::GROSS_EARNING => 'Gain (brut)',
            self::SALARY_DEDUCTION => 'Cotisation salariale (retenue)',
            self::EMPLOYER_CONTRIBUTION => 'Cotisation patronale',
            self::NET_EARNING => 'Net à payer',
            self::BENEFIT_IN_KIND => 'Avantage en nature',
        };
    }
}
