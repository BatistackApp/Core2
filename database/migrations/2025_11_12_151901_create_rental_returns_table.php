<?php

use App\Models\Locations\RentalContract;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rental_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(RentalContract::class)->constrained()->cascadeOnDelete();

            // Qui a réceptionné le retour
            $table->foreignIdFor(User::class)->nullable()->constrained('users')->onDelete('set null');


            $table->dateTime('returned_at');
            $table->text('condition_notes')->nullable()->comment('État des lieux au retour');

            // Coûts additionnels (casse, nettoyage...)
            $table->decimal('additional_costs')->nullable();
            $table->text('additional_costs_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_returns');
    }
};
