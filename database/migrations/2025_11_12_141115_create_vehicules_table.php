<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nom interne (ex: "Camion Benne 1", "Peugeot 3008 - Com 1")');
            $table->string('plate_number')->nullable()->nullable()->unique()->comment('Immatriculation (si applicable)');
            $table->string('vin_number')->nullable()->unique()->comment('Numéro de série');

            $table->string('brand')->nullable()->comment('Marque (ex: Renault, Caterpillar)');
            $table->string('model')->nullable()->comment('Modèle (ex: Master, 320D)');

            $table->string('type')->default('vehicle')->comment('vehicle, heavy_machinery, light_tooling');
            $table->string('status')->default('active')->comment('active, in_maintenance, sold, stolen');

            $table->date('purchased_at')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();

            // --- Intégration API Ulys (Péage) ---
            $table->string('toll_badge_number')->nullable()->unique()->comment('N° du badge télépéage (pour API Ulys)');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
