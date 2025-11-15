<?php

namespace App\Enums\NoteFrais;
use Filament\Support\Icons\Heroicon;

/**
 * Définit l'état de traitement OCR d'un justificatif.
 * Utilisé dans ExpenseReceipt->ocr_status.
 * [cite: modules/NoteDeFrais/architecture.md]
 */
enum ExpenseReceiptOcrStatus: string
{
    case PENDING = 'pending'; // En attente de traitement
    case PROCESSED = 'processed'; // Traité avec succès
    case FAILED = 'failed'; // Échec du traitement

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'En attente',
            self::PROCESSED => "En cours",
            self::FAILED => "Echec"
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::PROCESSED => 'success',
            self::FAILED => 'destructive'
        };
    }

    public function icon(): Heroicon
    {
        return match($this) {
            self::PENDING => Heroicon::Clock,
            self::PROCESSED => Heroicon::CheckCircle,
            self::FAILED => Heroicon::XCircle
        };
    }
}
