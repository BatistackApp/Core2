<?php

namespace App\Models\Banque;

use App\Enums\Banque\StatusBanqueConnection;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BankConnection extends Model
{
    protected $guarded = [];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir les comptes bancaires liés à cette connexion.
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class);
    }

    protected function casts(): array
    {
        return [
            'last_synced_at' => 'timestamp',
            'status' => StatusBanqueConnection::class,
        ];
    }
}
