<?php

namespace App\Models\Articles;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryLine extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Articles::class);
    }

    /**
     * Attribut virtuel pour calculer l'écart.
     */
    protected function difference(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) =>
                $attributes['real_quantity'] - $attributes['expected_quantity']
        );
    }

    /**
     * Attribut pour savoir si c'est une perte ou un gain.
     */
    protected function isLoss(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->difference < 0
        );
    }
}
