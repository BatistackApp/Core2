<?php

namespace App\Observer\NoteFrais;

use App\Models\NoteFrais\Expense;
use App\Models\NoteFrais\ExpenseReport;
use DB;

class ExpenseObserver
{
    /**
     * Gérer l'événement "saving" (avant création ou mise à jour).
     * Calcule le HT/TVA.
     */
    public function saving(Expense $expense): void
    {
        // Logique mise à jour pour tes champs
        // [cite: modules/NoteDeFrais/architecture.md]
        if ($expense->amount_ttc && $expense->vat_rate) {
            // Calcul "inversé"
            $vat_rate_decimal = $expense->vat_rate / 100;
            $expense->amount_ht = round($expense->amount_ttc / (1 + $vat_rate_decimal), 2);
            $expense->amount_vat = $expense->amount_ttc - $expense->amount_ht;
        } elseif ($expense->amount_ttc) {
            // Pas de TVA
            $expense->amount_ht = $expense->amount_ttc;
            $expense->amount_vat = 0;
        }
    }

    /**
     * Gérer l'événement "saved" (après création ou mise à jour).
     * Met à jour les totaux de l'en-tête ExpenseReport.
     */
    public function saved(Expense $expense): void
    {
        $this->updateExpenseReportTotals($expense->expenseReport);
    }

    /**
     * Gérer l'événement "deleted" (après suppression).
     * Met à jour les totaux de l'en-tête ExpenseReport.
     */
    public function deleted(Expense $expense): void
    {
        if ($expense->expenseReport) {
            $this->updateExpenseReportTotals($expense->expenseReport);
        }
    }

    /**
     * Met à jour les totaux de la note de frais parente.
     */
    protected function updateExpenseReportTotals(ExpenseReport $report): void
    {
        $totals = Expense::where('expense_report_id', $report->id)
            ->select(
                DB::raw('SUM(amount_ht) as total_ht'), // Mis à jour
                DB::raw('SUM(amount_ttc) as total_ttc') // Mis à jour
            )
            ->first();

        // [cite: app/Models/NoteFrais/ExpenseReport.php]
        $report->total_ht = $totals->total_ht ?? 0;
        $report->total_ttc = $totals->total_ttc ?? 0;

        $report->saveQuietly();
    }
}
