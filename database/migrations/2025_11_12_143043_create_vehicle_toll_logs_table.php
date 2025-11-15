<?php

use App\Models\Chantiers\Chantiers;
use App\Models\Flottes\Vehicule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicle_toll_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vehicule::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Chantiers::class)->nullable()->constrained()->onDelete('set null');

            $table->timestamp('transaction_date');
            $table->decimal('amount');

            $table->string('peage')->nullable()->comment('Nom du péage');
            $table->string('direction')->nullable();

            $table->string('provider')->default('ulys');
            $table->string('provider_transaction_id')->unique()->comment('ID unique de la transaction Ulys');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_toll_logs');
    }
};
