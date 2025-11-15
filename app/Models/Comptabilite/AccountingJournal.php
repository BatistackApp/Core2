<?php

namespace App\Models\Comptabilite;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountingJournal extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function planComptable(): BelongsTo
    {
        return $this->belongsTo(PlanComptable::class);
    }

    /**
     * Obtenir le compte par défaut (contrepartie) de ce journal.
     */
    public function defaultAccount(): BelongsTo
    {
        return $this->belongsTo(PlanComptable::class);
    }

    /**
     * Obtenir toutes les écritures (en-têtes) passées dans ce journal.
     */
    public function entries(): HasMany
    {
        return $this->hasMany(AccountingEntry::class, 'journal_id');
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
