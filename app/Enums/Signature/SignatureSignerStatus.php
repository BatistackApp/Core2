<?php

namespace App\Enums\Signature;

enum SignatureSignerStatus: string
{
    case PENDING = 'pending'; // En attente (pas encore envoyé, ex: workflow ordonné)
    case SENT = 'sent'; // Email envoyé
    case VIEWED = 'viewed'; // Document consulté
    case SIGNED = 'signed'; // Signé
    case REFUSED = 'refused'; // Signature refusée

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::SENT => 'Envoyé',
            self::VIEWED => 'Consulté',
            self::SIGNED => 'Signé',
            self::REFUSED => 'Refusé'
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::SENT => 'primary',
            self::VIEWED => 'secondary',
            self::SIGNED => 'success',
            self::REFUSED => 'destructive'
        };
    }
}
