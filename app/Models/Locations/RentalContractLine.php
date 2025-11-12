<?php

namespace App\Models\Locations;

use App\Enums\Locations\RentalPriceUnit;
use App\Observer\Locations\RentalContractLineObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[ObservedBy([RentalContractLineObserver::class])]
class RentalContractLine extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'price_unit' => RentalPriceUnit::class,
        'total_line_amount' => 'decimal:2',
    ];

    public function rentalContract(): BelongsTo
    {
        return $this->belongsTo(RentalContract::class);
    }

    /**
     * Obtenir l'item loué (Article ou Vehicule).
     * [cite: app/Models/Article.php]
     * [cite: app/Models/Flottes/Vehicule.php]
     */
    public function rentable(): MorphTo
    {
        return $this->morphTo();
    }
}
