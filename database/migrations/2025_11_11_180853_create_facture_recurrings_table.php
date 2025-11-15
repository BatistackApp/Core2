<?php

use App\Models\Tiers\Tiers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('facture_recurrings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tiers::class)->constrained()->onDelete('restrict');
            $table->string('status')->default('active');
            $table->string('frequency')->default('monthly');
            $table->date('start_at');
            $table->date('end_at')->nullable();
            $table->date('last_generated_at')->nullable();
            $table->date('next_generation_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facture_recurrings');
    }
};
