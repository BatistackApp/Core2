<?php

namespace App\Models\Flottes;

use App\Models\Chantiers\Chantiers;
use App\Observer\Flottes\VehicleTollLogObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([VehicleTollLogObserver::class])]
class VehicleTollLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function chantiers(): BelongsTo
    {
        return $this->belongsTo(Chantiers::class);
    }

    protected function casts(): array
    {
        return [
            'transaction_date' => 'datetime',
            'amount' => 'decimal:2', // J'ajoute la précision
        ];
    }
}
