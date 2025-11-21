<?php

namespace App\Observer\Articles;

use App\Models\Articles\Inventory;
use Illuminate\Validation\ValidationException;

class InventoryObserver
{
    public function updating(Inventory $inventory): void
    {
        // Si l'inventaire est déjà validé, on interdit toute modification
        // Sauf si c'est justement l'action de validation (changement de statut)
        if ($inventory->getOriginal('status') === 'validated' && $inventory->isDirty()) {
            throw ValidationException::withMessages([
                'status' => 'Impossible de modifier un inventaire déjà validé. Créez-en un nouveau pour corriger.',
            ]);
        }
    }

    public function deleting(Inventory $inventory): void
    {
        if ($inventory->status === 'validated') {
            throw ValidationException::withMessages([
                'status' => 'Impossible de supprimer un inventaire validé car il a impacté les stocks.',
            ]);
        }
    }
}
