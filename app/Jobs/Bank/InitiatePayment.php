<?php

namespace App\Jobs\Bank;

use App\Models\Banque\BankAccount;
use App\Models\Tiers\TiersBank;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class InitiatePayment implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ?TiersBank $beneficiaire,
        public BankAccount $bankAccount,
        public string $motif,
        public float $montant
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {

    }
}
