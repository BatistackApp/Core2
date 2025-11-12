<?php

namespace App\Models\Vision;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class BimLink extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bimObject(): BelongsTo
    {
        return $this->belongsTo(BimModel::class, 'bim_object_id');
    }

    /**
     * Obtenir l'objet métier (ChantierTask, ChantierPoste...) lié.
     * [cite: modules/Chantiers/architecture.md]
     * [cite: app/Models/ChantierPoste.php]
     */
    public function linkable(): MorphTo
    {
        return $this->morphTo();
    }
}
