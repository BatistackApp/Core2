<?php

namespace App\Models\Vision;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BimObjectMetadata extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bimModel(): BelongsTo
    {
        return $this->belongsTo(BimModel::class);
    }

    /**
     * Obtenir les liens métier (vers Tâches, Postes...)
     * de cet objet 3D.
     */
    public function links(): HasMany
    {
        return $this->hasMany(BimLink::class, 'bim_object_id');
    }

    protected function casts(): array
    {
        return [
            'properties' => 'json',
        ];
    }
}
