<?php

namespace App\Models\Flottes;

use App\Models\Chantiers\Chantiers;
use App\Models\User;
use App\Observer\Flottes\VehicleUsageLogObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([VehicleUsageLogObserver::class])]
class VehicleUsageLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chantiers(): BelongsTo
    {
        return $this->belongsTo(Chantiers::class);
    }

    protected function casts(): array
    {
        return [
            'log_date' => 'datetime',
            'mileage_start' => 'integer',
            'mileage_end' => 'integer',
            'hours_start' => 'integer',
            'hours_end' => 'integer',
        ];
    }
}
