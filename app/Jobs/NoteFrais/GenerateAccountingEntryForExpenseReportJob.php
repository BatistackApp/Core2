<?php

namespace App\Jobs\NoteFrais;

use App\Models\Comptabilite\AccountingEntry;
use App\Models\Comptabilite\AccountingJournal;
use App\Models\Comptabilite\PlanComptable;
use App\Models\NoteFrais\ExpenseReport;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class GenerateAccountingEntryForExpenseReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly ExpenseReport $expenseReport)
    {
    }

    public function handle(): void
    {
        try {
            DB::transaction(function () {
                $journal = AccountingJournal::where('type', 'od')->firstOrFail();

                // TODO: Récupérer le compte de contrepartie (467...) depuis les settings comptables
                $creditAccount = PlanComptable::where('account_number', '467000')->first(); // Simplification
                if (!$creditAccount) {
                    throw new \Exception("Compte de contrepartie 467000 non trouvé.");
                }

                // [cite: app/Models/AccountingEntry.php]
                $entry = AccountingEntry::create([
                    'journal_id' => $journal->id,
                    'sourceable_id' => $this->expenseReport->id,
                    'sourceable_type' => ExpenseReport::class,
                    'entry_date' => $this->expenseReport->approved_at ?? now(),
                    'reference' => 'NDF-' . $this->expenseReport->id,
                    'label' => 'Note de frais ' . $this->expenseReport->title,
                    'fiscal_year' => now()->year, // Simplification
                    'status' => 'validated',
                ]);

                $debitLines = $this->expenseReport->expenses()
                    ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
                    ->select(
                        'expense_categories.plan_comptable_id', // Mis à jour
                        DB::raw('SUM(expenses.amount_ht) as total_ht'), // Mis à jour
                        DB::raw('SUM(expenses.amount_vat) as total_vat') // Mis à jour
                    )
                    ->groupBy('expense_categories.plan_comptable_id')
                    ->get();

                // 5. Créer les lignes de débit (Charges)
                foreach ($debitLines as $line) {
                    // [cite: app/Models/AccountingEntryLine.php]
                    $entry->lines()->create([
                        'account_id' => $line->plan_comptable_id,
                        'tier_id' => null,
                        'label' => 'Charge NDF ' . $this->expenseReport->title,
                        'debit' => $line->total_ht,
                        'credit' => 0,
                    ]);
                    // TODO: Gérer la TVA (regroupée par compte de TVA)
                    if ($line->total_vat > 0) { /* ... ajouter ligne de TVA ... */ }
                }

                // 6. Créer la ligne de crédit (Contrepartie)
                $entry->lines()->create([
                    'account_id' => $creditAccount->id,
                    'tier_id' => null,
                    'label' => 'Remboursement NDF ' . $this->expenseReport->user->name,
                    'debit' => 0,
                    'credit' => $this->expenseReport->total_ttc, // Mis à jour
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Erreur compta NDF: ' . $e->getMessage());
        }
    }
}
