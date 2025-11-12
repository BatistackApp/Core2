<?php

use App\Models\Locations\RentalContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rental_contract_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(RentalContract::class)->constrained()->cascadeOnDelete();

            // --- Relation Polymorphique ---
            // 'rentable' peut être un 'Article' [cite: modules/Articles/architecture.md] (type='rental')
            // ou un 'Vehicule' [cite: app/Models/Flottes/Vehicule.php]
            $table->morphs('rentable');

            $table->string('description'); // Snapshot du nom de l'article/véhicule
            $table->decimal('quantity', 10, 2);

            $table->decimal('unit_price', 10, 2);
            $table->string('price_unit')->comment('par heure, jour, semaine...');

            $table->decimal('total_line_amount', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_contract_lines');
    }
};
