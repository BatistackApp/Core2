<?php

namespace App\Enums\Commerces;

enum StatusDevis: string
{
    case DRAFT = 'draft';
    case SUBMIT = 'submit';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';

    public function label():string
    {
        return match ($this) {
            self::DRAFT => 'Brouillon',
            self::SUBMIT => 'Envoyé',
            self::ACCEPTED => 'Accepté',
            self::REJECTED => 'Rejeté',
            self::CANCELLED => 'Annulé',
        };
    }

    public function color():string
    {
        return match ($this) {
            self::SUBMIT => 'primary',
            self::ACCEPTED => 'success',
            self::REJECTED, self::CANCELLED => 'destructive',
            default => 'mono',
        };
    }
}
