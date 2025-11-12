<?php

namespace App\Observer\NoteFrais;

use App\Enums\NoteFrais\ExpenseReportStatus;
use App\Jobs\NoteFrais\GenerateAccountingEntryForExpenseReportJob;
use App\Models\NoteFrais\ExpenseReport;

class ExpenseReportObserver
{
    /**
     * Gérer l'événement "updated" (après mise à jour).
     */
    public function updated(ExpenseReport $expenseReport): void
    {
        if ($expenseReport->wasChanged('status')) {

            // [cite: app/Enums/ExpenseReportStatus.php]
            if ($expenseReport->status === ExpenseReportStatus::APPROVED) {
                // [cite: modules/Comptabilite/architecture.md]
                GenerateAccountingEntryForExpenseReportJob::dispatch($expenseReport);
            }
        }
    }
}
