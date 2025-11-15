<?php

namespace App\Models\Comptabilite;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AccountingEntry extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function journal(): BelongsTo
    {
        return $this->belongsTo(AccountingJournal::class, 'journal_id');
    }

    /**
     * Obtenir les lignes (débit/crédit) de cette écriture.
     */
    public function lines(): HasMany
    {
        return $this->hasMany(AccountingEntryLine::class, 'entry_id');
    }

    /**
     * Obtenir le modèle source (Invoice, Payment, BankTransaction, etc.).
     */
    public function sourceable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function casts(): array
    {
        return [
            'entry_date' => 'date',
            'fiscal_year' => 'integer',
        ];
    }
}
