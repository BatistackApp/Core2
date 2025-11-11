<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employee_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('contract_type')->comment('CDI, CDD, Interim, Apprentissage...');
            $table->string('job_title')->comment('Titre du poste (ex: Maçon N3P2)');
            $table->text('job_description')->nullable();
            $table->date('start_at');
            $table->date('end_at')->nullable()->comment('Null pour un CDI');
            $table->decimal('base_salary')->comment('Salaire de base brut');
            $table->string('salary_period')->default('monthly')->comment('monthly, hourly');
            $table->decimal('weekly_hours', 5, 2)->default(35.00);
            $table->boolean('is_active')->default(true)->comment('Définit le contrat actuel');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_contracts');
    }
};
