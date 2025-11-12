<?php

namespace App\Models\Locations;

use App\Enums\Locations\RentalBillingFrequency;
use App\Enums\Locations\RentalContractStatus;
use App\Models\Chantiers\Chantiers;
use App\Models\Tiers\Tiers;
use App\Observer\Locations\RentalContractObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([RentalContractObserver::class])]
class RentalContract extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tiers(): BelongsTo
    {
        return $this->belongsTo(Tiers::class);
    }

    public function chantiers(): BelongsTo
    {
        return $this->belongsTo(Chantiers::class);
    }

    /**
     * Obtenir les lignes (items loués) de ce contrat.
     */
    public function lines(): HasMany
    {
        return $this->hasMany(RentalContractLine::class);
    }

    /**
     * Obtenir les enregistrements de disponibilité (réservations) liés.
     */
    public function availabilityBookings(): HasMany
    {
        return $this->hasMany(RentalAvailability::class);
    }

    /**
     * Obtenir les rapports de retour.
     */
    public function returns(): HasMany
    {
        return $this->hasMany(RentalReturn::class);
    }

    protected function casts(): array
    {
        return [
            'status' => RentalContractStatus::class,
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'billing_frequency' => RentalBillingFrequency::class,
            'last_billed_at' => 'date',
            'total_amount' => 'decimal:2',
        ];
    }
}
