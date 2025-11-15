<?php

namespace App\Models\Signature;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignatureQuota extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    protected $casts = [
        'total_allocated' => 'integer',
        'total_used' => 'integer',
    ];

    /**
     * Accessor pour calculer le solde restant.
     */
    protected function balance(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                $attributes['total_allocated'] - $attributes['total_used']
        );
    }

    /**
     * Vérifie si le quota est dépassé.
     */
    public function isQuotaExceeded(): bool
    {
        return $this->total_used >= $this->total_allocated;
    }
}
