<?php

namespace App\Models\GED;

use App\Enums\GED\DocumentStatus;
use App\Models\User;
use App\Observer\GED\DocumentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Tags\HasTags;

#[ObservedBy([DocumentObserver::class])]
class Document extends Model
{
    use HasFactory, HasTags;
    protected $guarded = [];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(DocumentCollection::class);
    }

    /**
     * Obtenir le modèle parent (Chantier, Invoice, User...)
     * auquel ce document est rattaché.
     */
    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Obtenir l'historique des versions de ce document.
     */
    public function versions(): HasMany
    {
        return $this->hasMany(DocumentVersion::class);
    }

    protected function casts(): array
    {
        return [
            'status' => DocumentStatus::class, // Cast vers l'Enum
            'current_size' => 'integer',
            'current_version_number' => 'integer',
            'is_signed' => 'boolean',
            'signed_at' => 'datetime',
        ];
    }
}
