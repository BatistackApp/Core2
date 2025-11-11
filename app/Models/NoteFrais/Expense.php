<?php

namespace App\Models\NoteFrais;

use App\Models\Banque\BankTransaction;
use App\Observer\NoteFrais\ExpenseObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

#[ObservedBy([ExpenseObserver::class])]
class Expense extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function expenseReport(): BelongsTo
    {
        return $this->belongsTo(ExpenseReport::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    /**
     * Obtenir les justificatifs (scans) de cette dépense.
     */
    public function receipts(): HasMany
    {
        return $this->hasMany(ExpenseReceipt::class);
    }

    /**
     * Obtenir la ligne de transaction bancaire
     * lors du rapprochement du remboursement (si applicable).
     */
    public function bankTransaction(): MorphOne
    {
        // Utile si le remboursement est rapproché ligne par ligne
        // (plus probable sur ExpenseReport)
        return $this->morphOne(BankTransaction::class, 'reconcilable');
    }

    protected function casts(): array
    {
        return [
            'expense_date' => 'date',
        ];
    }
}
