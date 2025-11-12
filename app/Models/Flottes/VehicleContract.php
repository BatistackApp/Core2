<?php

namespace App\Models\Flottes;

use App\Enums\Flottes\VehicleCostFrequency;
use App\Enums\Flottes\VehiculeContractType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleContract extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class);
    }

    protected function casts(): array
    {
        return [
            'type' => VehiculeContractType::class,
            'cost_amount' => 'decimal:2',
            'cost_frequency' => VehicleCostFrequency::class,
            'started_at' => 'date',
            'expires_at' => 'date',
        ];
    }
}
