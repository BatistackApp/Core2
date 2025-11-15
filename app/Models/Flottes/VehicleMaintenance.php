<?php

namespace App\Models\Flottes;

use App\Enums\Flottes\VehicleMaintenanceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Zap\Models\Concerns\HasSchedules;

class VehicleMaintenance extends Model
{
    use HasFactory, HasSchedules;
    protected $guarded = [];

    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class);
    }

    protected function casts(): array
    {
        return [
            'type' => VehicleMaintenanceType::class,
            'schedule_at' => 'date', // Corrigé
            'completed_at' => 'date',
            'cost_amount' => 'decimal:2',
        ];
    }
}
