<?php

namespace App\Enums\GRH;

use Filament\Support\Icons\Heroicon;

enum TypeEmployeeDocument: string
{
    case CONTRACT = 'contract';
    case CERTIFICATE = 'certificate';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::CONTRACT => 'Contrat',
            self::CERTIFICATE => 'Certificat',
            self::OTHER => 'Autre',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::CONTRACT => 'success',
            self::CERTIFICATE => 'warning',
            self::OTHER => 'secondary',
        };
    }

    public function icon(): Heroicon
    {
        return match ($this) {
            self::CONTRACT, self::CERTIFICATE => Heroicon::DocumentText,
            self::OTHER => Heroicon::Document,
        };
    }
}
