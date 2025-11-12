<?php

namespace App\Enums\Articles;

enum ArticleType: string
{
    case MATERIAL = 'material'; // Matériau stockable
    case SERVICE = 'service'; // Prestation de service
    case LABOR = 'labor'; // Main d'œuvre
    case OUVRAGE = 'ouvrage'; // Article composé (BOM)
    case RENTAL = 'rental'; // Article de location

    /**
     * Retourne le label en français.
     */
    public function label(): string
    {
        return match ($this) {
            self::MATERIAL => 'Matériau',
            self::SERVICE => 'Service',
            self::LABOR => 'Main d\'œuvre',
            self::OUVRAGE => 'Ouvrage',
            self::RENTAL => 'Location',
        };
    }

    /**
     * Retourne la couleur (pour l'UI).
     */
    public function color(): string
    {
        return match ($this) {
            self::MATERIAL => 'primary',
            self::SERVICE => 'info',
            self::LABOR => 'warning',
            self::OUVRAGE => 'success',
            self::RENTAL => 'destructive',
        };
    }

    /**
     * Retourne une icône Heroicon (pour l'UI).
     */
    public function icon(): string
    {
        return match ($this) {
            self::MATERIAL => 'heroicon-o-archive-box',
            self::SERVICE => 'heroicon-o-cog-6-tooth',
            self::LABOR => 'heroicon-o-user',
            self::OUVRAGE => 'heroicon-o-building-library',
            self::RENTAL => 'heroicon-o-key',
        };
    }
}
