<?php

use App\Models\Banque\BankConnection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nom du compte (ex: Compte Courant CIC, Caisse Espèces)');
            $table->string('type')->default('compte')->comment('compte, caisse');

            // --- Infos Bancaires (nullable pour les caisses) ---
            $table->string('bank_name')->nullable();
            $table->string('iban')->nullable();
            $table->string('bic')->nullable();

            $table->string('currency', 3)->default('EUR');

            // Solde (mis à jour par synchro ou manuellement)
            $table->decimal('current_balance', 12, 2)->default(0);
            $table->boolean('is_default')->default(false)->comment('Compte par défaut pour les opérations');

            // --- Champs d'Agrégation (Phase 8) ---
            $table->foreignIdFor(BankConnection::class)->nullable()->constrained()->onDelete('set null');
            $table->string('provider_account_id')->nullable()->comment('ID du compte chez le provider (Bridge)');
            $table->boolean('sync_enabled')->default(false);
            $table->timestamp('account_last_synced_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
