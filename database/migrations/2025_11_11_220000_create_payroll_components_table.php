<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payroll_components', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('Code interne (ex: URSSAF_C1, PRIM_PANIER, BRUT)');
            $table->string('name'); // Libellé (ex: Cotisation SS Maladie, Prime de panier)

            // Catégorisation pour le bulletin et les calculs
            $table->string('type')->comment('base, gross_earning, salary_deduction, employer_contribution, net_earning, benefit_in_kind');

            // Logique de Calcul
            $table->string('calculation_method')->default('fixed')->comment('fixed, rate, formula, variable');
            $table->decimal('rate', 8, 4)->nullable()->nullable()->comment('Taux (ex: 5.25%)');
            $table->decimal('fixed_amount', 10, 2)->nullable();
            $table->string('base_component_code')->nullable()->nullable()->comment('Code du composant servant d\'assiette (ex: BRUT)');
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_components');
    }
};
