<?php

use App\Models\Paie\PayrollComponent;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payroll_variables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade');

            // Lien vers le type de variable (ex: H_SUPP_25, PRIM_EXCEP)
            $table->foreignIdFor(PayrollComponent::class, 'component_id')->constrained('payroll_components')->onDelete('cascade');
            $table->date('applicable_date')->comment('Mois et année d\'application');
            $table->decimal('value', 10, 2)->comment('La valeur (ex: 10 heures, ou 150 euros)');
            $table->string('unit')->default('amount')->comment('amount, hours, days');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_variables');
    }
};
