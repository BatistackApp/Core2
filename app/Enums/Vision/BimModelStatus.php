<?php

namespace App\Enums\Vision;

enum BimModelStatus: string
{
    case PENDING = 'pending'; // En attente de traitement
    case PROCESSING = 'processing'; // Traitement en cours (Job)
    case COMPLETED = 'completed'; // Traité (fichier .glb prêt)
    case FAILED = 'failed'; // Échec du traitement

    /**
     * Retourne le label en français.
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::PROCESSING => 'Traitement en cours',
            self::COMPLETED => 'Terminé',
            self::FAILED => 'Échec',
        };
    }

    /**
     * Retourne la couleur (pour l'UI).
     */
    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::PROCESSING => 'warning',
            self::COMPLETED => 'success',
            self::FAILED => 'destructive',
        };
    }

    /**
     * Retourne une icône Heroicon (pour l'UI).
     */
    public function icon(): string
    {
        return match ($this) {
            self::PENDING => 'heroicon-o-clock',
            self::PROCESSING => 'heroicon-o-arrow-path',
            self::COMPLETED => 'heroicon-o-check-circle',
            self::FAILED => 'heroicon-o-exclamation-triangle',
        };
    }
}
