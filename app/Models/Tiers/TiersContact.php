<?php

namespace App\Models\Tiers;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TiersContact extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function tiers(): BelongsTo
    {
        return $this->belongsTo(Tiers::class);
    }

    /**
     * Accessor pour le nom complet.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['prenom'] . ' ' . $attributes['nom']
        );
    }
}
