<?php

namespace App\Enums\Facturation;

use Filament\Support\Icons\Heroicon;

enum StatusFacture: string
{
    case DRAFT = 'draft';
    case SENT = 'sent';
    case PAID = 'paid';
    case PARTIALLY_PAID = 'partially_paid';
    case OVERDUE = 'overdue';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Brouillon',
            self::SENT => 'Envoyer',
            self::PAID => 'Payer',
            self::PARTIALLY_PAID => 'Partiellement payer',
            self::OVERDUE => "Retard",
            self::CANCELLED => 'Annuler',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'mono',
            self::SENT => 'primary',
            self::PAID => 'success',
            self::PARTIALLY_PAID => 'warning',
            self::OVERDUE => "destructive",
            self::CANCELLED => 'secondary',
        };
    }

    public function icon(): Heroicon
    {
        return match ($this) {
            self::DRAFT => Heroicon::Pencil,
            self::SENT => Heroicon::PaperAirplane,
            self::PAID => Heroicon::CheckCircle,
            self::PARTIALLY_PAID => Heroicon::ExclamationCircle,
            self::OVERDUE, self::CANCELLED => Heroicon::XCircle,
        };
    }
}
