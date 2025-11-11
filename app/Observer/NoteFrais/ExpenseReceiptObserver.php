<?php

namespace App\Observer\NoteFrais;

use App\Jobs\NoteFrais\ProcessOcrJob;
use App\Models\NoteFrais\ExpenseReceipt;

class ExpenseReceiptObserver
{
    /**
     * Gérer l'événement "created" (après création).
     */
    public function created(ExpenseReceipt $expenseReceipt): void
    {
        // [cite: app/Models/NoteFrais/ExpenseReceipt.php]
        ProcessOcrJob::dispatch($expenseReceipt);
    }
}
