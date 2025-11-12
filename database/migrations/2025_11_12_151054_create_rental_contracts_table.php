<?php

use App\Models\Chantiers\Chantiers;
use App\Models\Tiers\Tiers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rental_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tiers::class)->constrained()->cascadeOnDelete(); // Client (locataire)
            $table->foreignIdFor(Chantiers::class)->nullable()->constrained()->onDelete('restrict'); // Chantier (pour imputation des coûts)

            $table->string('number')->unique(); // Ex: "LOC-2027-0001"
            $table->string('status')->default('draft')->comment('draft, active, completed, cancelled');

            // Période de location
            $table->dateTime('start_date');
            $table->dateTime('end_date');

            // --- Facturation Automatique ---
            $table->string('billing_frequency')->default('daily')->comment('daily, weekly, monthly, on_time');
            $table->date('last_billed_at')->nullable()->comment('Date de la dernière facture générée');

            $table->string('total_amount')->nullable(); // Totaux (calculés depuis les lignes)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_contracts');
    }
};
