<?php

namespace App\Models\GPAO;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Zap\Models\Concerns\HasSchedules;

class ProductionLine extends Model
{
    use HasFactory, HasSchedules;
    protected $guarded = [];

    public $timestamps = false;

    /**
     * Obtenir les opérations de production effectuées sur cette ligne.
     */
    public function operations(): HasMany
    {
        return $this->hasMany(ProductionOrderOperation::class);
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
