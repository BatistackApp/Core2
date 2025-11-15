<?php

use App\Models\Flottes\Vehicule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicle_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vehicule::class)->constrained()->cascadeOnDelete();

            $table->string('type')->comment('preventive, corrective');
            $table->string('description'); // Ex: "Vidange 50 000 km", "Remplacement pneu AV D"

            // Planification [cite: Roadmap.md]
            $table->date('schedule_at')->nullable();

            // Réalisation
            $table->date('completed_at')->nullable();
            $table->decimal('cost_amount', 10, 2)->nullable();
            $table->string('provider_name')->nullable()->comment('Garage, interne...');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_maintenances');
    }
};
