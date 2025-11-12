<?php

namespace App\Models\Banque;

use App\Enums\Banque\TypeBanqueAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BankAccount extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Obtenir les transactions de ce compte.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(BankTransaction::class);
    }

    public function bankConnection(): BelongsTo
    {
        return $this->belongsTo(BankConnection::class);
    }

    protected function casts(): array
    {
        return [
            'current_balance' => 'decimal:2',
            'is_default' => 'boolean',
            'sync_enabled' => 'boolean',
            'account_last_synced_at' => 'datetime',
            'type' => TypeBanqueAccount::class,
        ];
    }
}
