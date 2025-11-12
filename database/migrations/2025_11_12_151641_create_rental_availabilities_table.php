<?php

use App\Models\Locations\RentalContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rental_availabilities', function (Blueprint $table) {
            $table->id();

            // Le contrat qui bloque la dispo
            $table->foreignIdFor(RentalContract::class)->constrained()->cascadeOnDelete();

            // L'item réservé (Article ou Véhicule)
            $table->morphs('rentable');

            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->decimal('quantity_reserved', 10, 2);

            $table->timestamps();

            $table->index(['rentable_type', 'rentable_id', 'start_date', 'end_date'], 'rental_availability_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_availabilities');
    }
};
