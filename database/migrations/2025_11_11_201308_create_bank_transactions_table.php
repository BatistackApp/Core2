<?php

use App\Models\Banque\BankAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BankAccount::class)->constrained()->cascadeOnDelete();
            $table->date('transaction_date')->comment('Date de l\'opération');
            $table->date('value_date')->nullable()->comment('Date de valeur');

            $table->string('label', 255);
            $table->decimal('amount', 12, 2)->comment('Montant (positif = crédit, négatif = débit)');

            $table->string('bank_reference')->nullable()->comment('Référence (import manuel)');

            // --- Champs d'Agrégation (Phase 8) ---
            $table->string('provider_transaction_id')->nullable()->comment('ID unique de transaction (Bridge)');
            $table->boolean('is_from_sync')->default(false);

            // --- Rapprochement ---
            // [cite: Roadmap.md] "Rapprochement bancaire manuel"
            $table->string('status')->default('unreconciled')->comment('unreconciled, reconciled');

            // Lien polymorphique pour le rapprochement
            $table->morphs('reconcilable');

            $table->timestamp('reconciled_at')->nullable();
            $table->foreignId('reconciled_by_user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();

            $table->index('bank_reference');
            $table->index('transaction_date');
            // Index unique pour éviter les doublons lors de la synchro
            $table->unique(['bank_account_id', 'provider_transaction_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_transactions');
    }
};
