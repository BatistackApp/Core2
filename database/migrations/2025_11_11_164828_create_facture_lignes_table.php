<?php

use App\Models\Facturation\Facture;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('facture_lignes', function (Blueprint $table) {
            $table->id();
            $table->string('description');

            // Taux de TVA (Snapshot du paramètre par défaut, surchargeable)
            $table->decimal('vat_rate')->default(20.0);

            // --- Cas 1: Facturation Standard (Article) ---
            $table->decimal('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('unit_price_ht')->nullable();

            // --- Cas 2: Situation de Travaux (Poste BTP) ---
            $table->decimal('total_budget_amount')->nullable()->comment('Montant total du poste (copié de chantier_poste)');
            $table->decimal('previous_progress_percentage')->nullable()->comment('Avancement N-1 (ex: 30.00)');
            $table->decimal('current_progress_percentage')->nullable()->comment('Nouvel avancement (ex: 40.00)');

            // --- Totaux de Ligne (Calculés) ---
            // Si BTP: ((current_progress - previous_progress) / 100) * total_budget_amount
            // Si Standard: quantity * unit_price_excl_tax
            $table->decimal('amount_ht');
            $table->decimal('amount_tva');
            $table->decimal('amount_tc');

            $table->foreignIdFor(Facture::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Chantiers\ChantiersPoste::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignIdFor(\App\Models\Articles\Articles::class)->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facture_lignes');
    }
};
