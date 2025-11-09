<?php

use App\Models\Comptabilite\PlanComptable;
use App\Models\Core\ConditionReglement;
use App\Models\Core\ModeReglement;
use App\Models\Tiers\Tiers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tiers_customers', function (Blueprint $table) {
            $table->id();
            $table->boolean('tva');
            $table->string('num_tva')->nullable();
            $table->string('rem_relative');
            $table->string('rem_fixe');
            $table->foreignIdFor(PlanComptable::class, 'code_comptable_general')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(PlanComptable::class, 'code_comptable_client')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Tiers::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(ConditionReglement::class)->constrained();
            $table->foreignIdFor(ModeReglement::class)->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiers_customers');
    }
};
