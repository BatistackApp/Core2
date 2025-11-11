<?php

namespace App\Models\NoteFrais;

use App\Enums\NoteFrais\ExpenseReportStatus;
use App\Models\User;
use App\Observer\NoteFrais\ExpenseReportObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([ExpenseReportObserver::class])]
class ExpenseReport extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Obtenir les lignes de dépense de cette note.
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    protected function casts(): array
    {
        return [
            'status' => ExpenseReportStatus::class, // Cast vers l'Enum
            'period_start_date' => 'date',
            'period_end_date' => 'date',
            'total_amount' => 'decimal:2',
            'total_vat_amount' => 'decimal:2',
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
            'reimbursed_at' => 'datetime',
        ];
    }
}
