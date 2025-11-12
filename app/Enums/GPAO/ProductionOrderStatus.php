<?php

namespace App\Enums\GPAO;

use Filament\Support\Icons\Heroicon;

enum ProductionOrderStatus: string
{
    case DRAFT = 'draft'; // Brouillon
    case PLANNED = 'planned'; // Planifié (composants réservés)
    case IN_PROGRESS = 'in_progress'; // En cours de fabrication
    case COMPLETED = 'completed'; // Terminé (produit fini créé en stock)
    case CANCELLED = 'cancelled'; // Annulé

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Brouillon',
            self::PLANNED => 'Planifié',
            self::IN_PROGRESS => 'En cours',
            self::COMPLETED => 'Terminé',
            self::CANCELLED => 'Annulé',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'secondary',
            self::PLANNED => 'primary',
            self::IN_PROGRESS => 'info',
            self::COMPLETED => 'success',
            self::CANCELLED => 'destructive',
        };
    }

    public function icon(): Heroicon
    {
        return match ($this) {
            self::DRAFT => Heroicon::PencilSquare,
            self::PLANNED => Heroicon::CalendarDays,
            self::IN_PROGRESS => Heroicon::Clock,
            self::COMPLETED => Heroicon::CheckCircle,
            self::CANCELLED => Heroicon::XCircle,
        };
    }
}
