<?php

use App\Models\Paie\PaySlip;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pay_slip_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PaySlip::class)->constrained('pay_slips')->onDelete('cascade');
            $table->string('component_code');
            $table->string('label');
            $table->string('type')->comment('Type de composant (ex: cot_sal, cot_pat, brut...)');

            // --- Calcul (Snapshot) ---
            $table->decimal('base_amount')->nullable()->comment('Assiette');
            $table->decimal('rate')->nullable()->comment('Taux appliqué');

            // --- Résultats ---
            $table->decimal('gain_amount', 10, 2)->nullable()->comment('Gains (colonne Salarié Brut)');
            $table->decimal('deduction_amount', 10, 2)->nullable()->comment('Déductions (colonne Salarié Cotisations)');
            $table->decimal('employer_amount', 10, 2)->nullable()->comment('Coût (colonne Employeur Cotisations)');

            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pay_slip_lines');
    }
};
