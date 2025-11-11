<?php

use App\Models\Comptabilite\AccountingJournal;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accounting_entries', function (Blueprint $table) {
            $table->id();
            // Journal auquel l'écriture est rattachée
            $table->foreignId('journal_id')->constrained('accounting_journals')->onDelete('restrict');

            // Lien polymorphique vers la source (Facture, Paiement, Transaction...)
            $table->morphs('sourceable'); // ex: sourceable_id=5, sourceable_type='App\Models\Invoice'

            $table->date('entry_date')->comment('Date de comptabilisation');
            $table->string('reference')->nullable()->comment('Ex: "FA-2026-0001"');
            $table->string('label'); // Libellé de l'opération

            // L'exercice fiscal auquel l'écriture est rattachée
            $table->unsignedSmallInteger('fiscal_year');

            // Statut (pour brouillard / validation)
            $table->string('status')->default('draft')->comment('draft, validated');

            $table->timestamps();

            $table->index('entry_date');
            $table->index('fiscal_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounting_entries');
    }
};
