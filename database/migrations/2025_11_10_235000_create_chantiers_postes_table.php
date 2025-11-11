<?php

use App\Models\Chantiers\Chantiers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chantiers_postes', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('quantity');
            $table->string('unit')->nullable();
            $table->decimal('unit_price_ht');
            $table->decimal('total_budget_amount');
            $table->decimal('current_progress_percentage');
            $table->foreignIdFor(Chantiers::class);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chantiers_postes');
    }
};
