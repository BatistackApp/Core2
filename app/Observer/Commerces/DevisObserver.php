<?php

namespace App\Observer\Commerces;

use App\Models\Commerces\Devis;
use Str;

class DevisObserver
{
    public function creating(Devis $devis): void
    {
        $devis->num_devis = "DE".now()->format('Y').strtoupper(Str::random(4));
        $devis->amount_ht = 0;
        $devis->amount_ttc = 0;
        $devis->responsable_id = auth()->id();
    }
}
