<?php

namespace App\Enums\Signature;

use Filament\Support\Icons\Heroicon;

enum SignatureProcedureStatus: string
{
    case DRAFT = 'draft'; // Brouillon
    case SENT = 'sent'; // Envoyé (en attente de signataires)
    case COMPLETED = 'completed'; // Terminé (tous ont signé)
    case CANCELLED = 'cancelled'; // Annulé par l'initiateur
    case EXPIRED = 'expired'; // Expiré (date limite dépassée)

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Brouillon',
            self::SENT => 'Envoyé',
            self::COMPLETED => 'Terminé',
            self::CANCELLED => 'Annulé',
            self::EXPIRED => 'Expiré'
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'secondary',
            self::SENT => 'primary',
            self::COMPLETED => 'success',
            self::CANCELLED => 'destructive',
            self::EXPIRED => 'warning'
        };
    }

    public function icon(): Heroicon
    {
        return match ($this) {
            self::DRAFT => Heroicon::PencilSquare,
            self::SENT => Heroicon::PaperAirplane,
            self::COMPLETED => Heroicon::CheckCircle,
            self::CANCELLED => Heroicon::XCircle,
            self::EXPIRED => Heroicon::ExclamationTriangle
        };
    }
}
