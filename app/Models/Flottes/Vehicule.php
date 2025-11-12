<?php

namespace App\Models\Flottes;

use App\Enums\Flottes\VehiculeStatus;
use App\Enums\Flottes\VehiculeType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zap\Models\Concerns\HasSchedules;

class Vehicule extends Model
{
    use HasFactory, SoftDeletes, HasSchedules;
    protected $guarded = [];

    /**
     * Obtenir les contrats (assurance, leasing...) de ce véhicule.
     * [cite: 2025_11_12_141507_create_vehicle_contracts_table.php]
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(VehicleContract::class);
    }

    /**
     * Obtenir l'historique de maintenance de ce véhicule.
     * [cite: 2025_11_12_142339_create_vehicle_maintenances_table.php]
     */
    public function maintenances(): HasMany
    {
        return $this->hasMany(VehicleMaintenance::class);
    }

    /**
     * Obtenir les logs d'utilisation (km, heures) de ce véhicule.
     * [cite: 2025_11_12_142740_create_vehicle_usage_logs_table.php]
     */
    public function usageLogs(): HasMany
    {
        return $this->hasMany(VehicleUsageLog::class);
    }

    /**
     * Obtenir les logs de péage (Ulys) de ce véhicule.
     * [cite: 2025_11_12_143043_create_vehicle_toll_logs_table.php]
     */
    public function tollLogs(): HasMany
    {
        return $this->hasMany(VehicleTollLog::class);
    }

    protected function casts(): array
    {
        return [
            'type' => VehiculeType::class,
            'status' => VehiculeStatus::class,
            'purchased_at' => 'date',
            'purchase_price' => 'decimal:2',
        ];
    }
}
