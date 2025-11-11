<?php

namespace App\Enums\Facturation;

enum TypeFacture: string
{
    case STANDARD = 'standard';
    case DOWN_PAYMENT = 'down_payment';
    case CREDIT_NOTE = 'credit_note';
    case WORK_SITUATION = 'work_situation';
    case FINAL_SETTLEMENT = 'final_settlement';

    public function label():string
    {
        return match ($this) {
            self::STANDARD => 'Facture',
            self::DOWN_PAYMENT => 'Acompte',
            self::CREDIT_NOTE => 'Avoir',
            self::WORK_SITUATION => 'Situation de travail',
            self::FINAL_SETTLEMENT => 'Facture finale'
        };
    }
}
