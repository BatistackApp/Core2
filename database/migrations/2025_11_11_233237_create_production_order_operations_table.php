<?php

use App\Models\GPAO\ProductionLine;
use App\Models\GPAO\ProductionOrder;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('production_order_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProductionOrder::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignIdFor(ProductionLine::class)->nullable()->constrained()->onDelete('set null');

            $table->text('description')->nullable()->comment('Ex: Découpe, Assemblage, Peinture');

            // Suivi du temps (coût de main d'œuvre)
            $table->decimal('time_spent_hours', 8, 2)->default(0);
            $table->decimal('hourly_cost', 10, 2)->nullable()->comment('Snapshot du coût horaire de l\'employé/machine');

            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_order_operations');
    }
};
