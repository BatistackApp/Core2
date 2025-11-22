<?php

namespace App\Enums\Articles;

use Filament\Support\Icons\Heroicon;

enum InventoryStatus: string
{
    case DRAFT = 'draft';
    case PROCESSING = 'processing';
    case VALIDATED = 'validated';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => "Brouillon",
            self::PROCESSING => "En cours",
            self::VALIDATED => "Validé",
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => "primary",
            self::PROCESSING => "info",
            self::VALIDATED => "success",
        };
    }

    public function icon(): Heroicon
    {
        return match ($this) {
            self::DRAFT => Heroicon::Pencil,
            self::PROCESSING => Heroicon::Clock,
            self::VALIDATED => Heroicon::Check,
        };
    }
}
