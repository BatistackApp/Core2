<?php

use App\Models\Comptabilite\AccountingEntry;
use App\Models\Comptabilite\PlanComptable;
use App\Models\Tiers\Tiers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accounting_entry_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AccountingEntry::class, 'entry_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(PlanComptable::class)->constrained()->onDelete('restrict');
            $table->foreignIdFor(Tiers::class)->nullable()->constrained()->onDelete('set null');
            $table->string('label');
            $table->decimal('debit', 12, 2)->default(0);
            $table->decimal('credit', 12, 2)->default(0);
            $table->timestamps();

            $table->unique(['plan_comptable_id', 'tiers_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounting_entry_lines');
    }
};
