<?php

namespace App\Jobs\Chantiers;

use App\Models\Chantiers\Chantiers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class UpdateChantierActualCostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $chantierId,
        public float $costAmount,
        public string $costType
    ){}

    public function handle(): void
    {
        $chantier = Chantiers::find($this->chantierId);

        if (!$chantier) {
            Log::warning("Impossible d'imputer le coût : Chantier ID {$this->chantierId} non trouvé.");
            return;
        }

        $chantier->increment('total_actual_cost', $this->costAmount);
    }
}
