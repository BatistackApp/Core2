<?php

namespace App\Enums\GED;

enum DocumentStatus: string
{
    case ACTIVE = 'active';
    case ARCHIVED = 'archived';
    case DRAFT = 'draft';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Actif',
            self::ARCHIVED => 'Archivé',
            self::DRAFT => 'Brouillon',
        };
    }
}
