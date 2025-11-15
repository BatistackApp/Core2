<?php

namespace App\Models\NoteFrais;

use App\Enums\NoteFrais\ExpenseReceiptOcrStatus;
use App\Observer\NoteFrais\ExpenseReceiptObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([ExpenseReceiptObserver::class])]
class ExpenseReceipt extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }

    protected function casts(): array
    {
        return [
            'size' => 'integer',
            'ocr_detected_amount' => 'decimal:2',
            'ocr_detected_date' => 'date',
            'ocr_status' => ExpenseReceiptOcrStatus::class, // Cast vers l'Enum
        ];
    }
}
