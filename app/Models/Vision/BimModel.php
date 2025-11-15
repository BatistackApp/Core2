<?php

namespace App\Models\Vision;

use App\Enums\Vision\BimModelStatus;
use App\Models\Chantiers\Chantiers;
use App\Observer\Vision\BimModelObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([BimModelObserver::class])]
class BimModel extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'processing_status' => BimModelStatus::class,
    ];

    public function chantiers(): BelongsTo
    {
        return $this->belongsTo(Chantiers::class);
    }

    /**
     * Obtenir tous les objets (métadonnées) extraits de cette maquette.
     */
    public function objects(): HasMany
    {
        return $this->hasMany(BimObjectMetadata::class);
    }
}
