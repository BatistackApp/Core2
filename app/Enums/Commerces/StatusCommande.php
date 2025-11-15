<?php

namespace App\Enums\Commerces;

use Filament\Support\Icons\Heroicon;

enum StatusCommande: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case WAITING = 'waiting';
    case DELIVERED = 'delivered';
    case CANCELED = 'canceled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::CONFIRMED => 'Confirmé',
            self::WAITING => 'En cours',
            self::DELIVERED => 'Livré',
            self::CANCELED => 'Annulé',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::CONFIRMED => 'secondary',
            self::WAITING => 'warning',
            self::DELIVERED => 'success',
            self::CANCELED => 'destructive',
            default => 'mono',
        };
    }

    public function icon(): Heroicon
    {
        return match ($this) {
            self::PENDING => Heroicon::Clock,
            self::CONFIRMED, self::DELIVERED => Heroicon::CheckCircle,
            self::WAITING => Heroicon::Truck,
            self::CANCELED => Heroicon::XCircle,
        };
    }
}
