<?php

namespace App\Enums\NoteFrais;

use Filament\Support\Icons\Heroicon;

enum ExpenseReportStatus: string
{
    case DRAFT = 'draft'; // Brouillon, en cours de saisie
    case SUBMITTED = 'submitted'; // Soumis, en attente de validation
    case APPROVED = 'approved'; // Approuvé, en attente de remboursement
    case REJECTED = 'rejected'; // Rejeté
    case REIMBURSED = 'reimbursed'; // Remboursé

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Brouillon',
            self::SUBMITTED => 'Soumis',
            self::APPROVED => "Approuvé",
            self::REJECTED => "Rejeté",
            self::REIMBURSED => "Remboursé",
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'warning',
            self::SUBMITTED => 'primary',
            self::APPROVED => 'success',
            self::REJECTED => 'destructive',
            self::REIMBURSED => 'secondary',
        };
    }

    public function icon(): Heroicon
    {
        return match ($this) {
            self::DRAFT => Heroicon::PencilSquare,
            self::SUBMITTED => Heroicon::PaperAirplane,
            self::APPROVED => Heroicon::CheckCircle,
            self::REJECTED => Heroicon::XCircle,
            self::REIMBURSED => Heroicon::CurrencyEuro,
        };
    }
}
