<?php

use App\Models\Comptabilite\PlanComptable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accounting_journals', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Code journal (ex: "VE", "AC", "BQ", "OD")
            $table->string('name'); // Libellé (ex: "Journal des Ventes")
            $table->string('type'); // Type (vente, achat, banque, od)
            $table->foreignIdFor(PlanComptable::class)->nullable()->constrained()->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounting_journals');
    }
};
