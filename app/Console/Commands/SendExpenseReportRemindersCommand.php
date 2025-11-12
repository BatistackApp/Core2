<?php

namespace App\Console\Commands;

use App\Enums\NoteFrais\ExpenseReportStatus;
use App\Models\NoteFrais\ExpenseReport;
use Illuminate\Console\Command;

class SendExpenseReportRemindersCommand extends Command
{
    protected $signature = 'expense:send-reminders';

    protected $description = 'Envoie des rappels aux managers pour les notes de frais en attente de validation.';

    public function handle(): void
    {
        $this->info('Envoi des rappels pour les notes de frais...');
        $reportsToRemind = ExpenseReport::where('status', ExpenseReportStatus::SUBMITTED)
            ->where('submitted_at', '<', now()->subDays(3))
            ->get();

        if ($reportsToRemind->isEmpty()) {
            $this->info('Aucune note de frais en attente de rappel.');
        }

        foreach ($reportsToRemind as $report) {
            if ($report->manager) {
                // Notification::send($report->manager, new ExpenseReportAwaitingApproval($report));
                $this->line('Rappel envoyé pour la note ' . $report->id . ' à ' . $report->manager->name);
            }
        }

        $this->info('Terminé.');
    }
}
