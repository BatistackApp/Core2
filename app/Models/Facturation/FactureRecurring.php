<?php

namespace App\Models\Facturation;

use App\Enums\Facturation\FrequencyFactureRecurring;
use App\Enums\Facturation\StatusFactureReccuring;
use App\Models\Tiers\Tiers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactureRecurring extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tiers(): BelongsTo
    {
        return $this->belongsTo(Tiers::class);
    }

    protected function casts(): array
    {
        return [
            'start_at' => 'date',
            'end_at' => 'date',
            'last_generated_at' => 'date',
            'next_generation_at' => 'date',
            'status' => StatusFactureReccuring::class,
            'frequency' => FrequencyFactureRecurring::class,
        ];
    }
}
