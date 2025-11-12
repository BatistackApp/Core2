<?php

namespace App\Models\Tiers;

use App\Enums\Tiers\TiersNature;
use App\Enums\Tiers\TiersType;
use App\Observer\Tiers\TiersObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Zap\Models\Concerns\HasSchedules;

#[ObservedBy([TiersObserver::class])]
class Tiers extends Model
{
    use HasFactory, HasSchedules;

    public $timestamps = false;
    protected $guarded = [];

    public function addresses(): Tiers|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TiersAddress::class);
    }

    /**
     * Obtenir le profil Client (si la nature est Client).
     * [cite: 2025_11_09_200620_create_tiers_customers_table.php]
     */
    public function customerProfile(): HasOne
    {
        return $this->hasOne(TiersCustomer::class);
    }

    /**
     * Obtenir le profil Fournisseur (si la nature est Fournisseur).
     * [cite: 2025_11_09_200240_create_tiers_supplies_table.php]
     */
    public function supplyProfile(): HasOne
    {
        return $this->hasOne(TiersSupply::class);
    }

    /**
     * Obtenir les contacts associés à ce tiers.
     * [cite: 2025_11_09_195856_create_tiers_contacts_table.php]
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(TiersContact::class);
    }

    /**
     * Obtenir les comptes bancaires associés à ce tiers.
     * [cite: 2025_11_09_201111_create_tiers_banks_table.php]
     */
    public function banks(): HasMany
    {
        return $this->hasMany(TiersBank::class);
    }

    /**
     * Obtenir l'historique (logs) associé à ce tiers.
     * [cite: 2025_11_09_200904_create_tiers_logs_table.php]
     */
    public function logs(): HasMany
    {
        return $this->hasMany(TiersLog::class);
    }

    protected function casts(): array
    {
        return [
            'nature' => TiersNature::class, // [cite: TiersNature.php]
            'type' => TiersType::class,     // [cite: TiersType.php]
            'tva' => 'boolean',
        ];
    }

}
