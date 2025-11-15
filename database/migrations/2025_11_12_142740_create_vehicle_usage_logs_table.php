<?php

use App\Models\Chantiers\Chantiers;
use App\Models\Flottes\Vehicule;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicle_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vehicule::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignIdFor(Chantiers::class)->nullable()->constrained()->onDelete('set null');

            $table->dateTime('log_date');

            // Kilométrage (pour véhicules)
            $table->unsignedBigInteger('mileage_start')->nullable();
            $table->unsignedBigInteger('mileage_end')->nullable();

            // Horodatage (pour engins)
            $table->unsignedBigInteger('hours_start')->nullable();
            $table->unsignedBigInteger('hours_end')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_usage_logs');
    }
};
