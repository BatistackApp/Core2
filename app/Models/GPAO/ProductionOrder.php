<?php

namespace App\Models\GPAO;

use App\Enums\GPAO\ProductionOrderStatus;
use App\Models\Articles\Articles;
use App\Models\Chantiers\Chantiers;
use App\Models\Commerces\Commande;
use App\Observer\GPAO\ProductionOrderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([ProductionOrderObserver::class])]
class ProductionOrder extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function articles(): BelongsTo
    {
        return $this->belongsTo(Articles::class);
    }

    public function chantiers(): BelongsTo
    {
        return $this->belongsTo(Chantiers::class);
    }

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }

    /**
     * Obtenir les composants (matériaux) requis pour cet OF.
     */
    public function components(): HasMany
    {
        return $this->hasMany(ProductionOrderComponent::class);
    }

    /**
     * Obtenir les opérations (suivi temps/MO) de cet OF.
     */
    public function operations(): HasMany
    {
        return $this->hasMany(ProductionOrderOperation::class);
    }

    protected function casts(): array
    {
        return [
            'quantity_to_produce' => 'decimal:2',
            'quantity_produced' => 'decimal:2',
            'due_date' => 'date',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'status' => ProductionOrderStatus::class, // Cast vers l'Enum
            'estimated_cost' => 'decimal:2',
            'actual_cost' => 'decimal:2',
        ];
    }
}
