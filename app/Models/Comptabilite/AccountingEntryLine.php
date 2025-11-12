<?php

namespace App\Models\Comptabilite;

use App\Models\Tiers\Tiers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountingEntryLine extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function entry(): BelongsTo
    {
        return $this->belongsTo(AccountingEntry::class, 'entry_id');
    }

    public function planComptable(): BelongsTo
    {
        return $this->belongsTo(PlanComptable::class);
    }

    public function tiers(): BelongsTo
    {
        return $this->belongsTo(Tiers::class);
    }

    protected $casts = [
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
    ];
}
