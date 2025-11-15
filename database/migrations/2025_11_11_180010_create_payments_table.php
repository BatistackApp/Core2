<?php

use App\Models\Core\ModeReglement;
use App\Models\Tiers\Tiers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tiers::class)->constrained()->onDelete('restrict');
            $table->decimal('amount', 10, 2);
            $table->date('paid_at');
            $table->foreignIdFor(ModeReglement::class);
            $table->string('reference')->nullable();
            $table->string('status')->default('unallocated');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
