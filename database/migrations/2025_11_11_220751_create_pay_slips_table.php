<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pay_slips', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade');
            $table->foreignId('employee_contract_id')->nullable()->constrained('employee_contracts')->onDelete('set null');


            $table->string('period_year',4);
            $table->string('period_month',2);
            $table->date('period_start_at');
            $table->date('period_end_at');

            $table->string('status')->default('draft')->comment('draft, calculated, validated, paid, archived');

            // --- Totaux (Calculés depuis les lignes) ---
            $table->decimal('total_gross_salary', 10, 2)->comment('Total Brut');
            $table->decimal('total_salary_deductions', 10, 2)->comment('Total Cotisations Salariales');
            $table->decimal('total_employer_contributions', 10, 2)->comment('Total Cotisations Patronales');
            $table->decimal('net_salary', 10, 2)->comment('Net avant impôt');
            $table->decimal('net_payable', 10, 2)->comment('Net à payer');

            // Lien vers le document PDF (Module GED / EmployeeDocument)
            $table->string('document_path')->nullable();
            $table->foreignIdFor(\App\Models\GRH\EmployeeDocument::class)->nullable()->constrained()->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pay_slips');
    }
};
