<?php

namespace App\Models\Banque;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class BankTransaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class);
    }

    /**
     * Obtenir l'utilisateur qui a rapproché la transaction.
     */
    public function reconciledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reconciled_by_user_id');
    }

    /**
     * Obtenir le modèle parent (Payment, Expense, etc.)
     * auquel cette transaction est rapprochée.
     */
    public function reconcilable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'value_date' => 'date',
            'is_from_sync' => 'boolean',
            'amount' => 'decimal:2',
            'reconciled_at' => 'datetime',
        ];
    }
}
