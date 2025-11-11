<?php

use App\Models\Comptabilite\PlanComptable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ex: "Restaurant", "Indemnité Kilométrique"
            $table->string('code')->nullable(); // Ex: "RESTO", "IK"
            $table->foreignIdFor(PlanComptable::class)->nullable()->constrained()->onDelete('set null');
            $table->boolean('requires_receipt')->default(true)->comment('Justificatif obligatoire ?');
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_categories');
    }
};
