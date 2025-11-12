<?php

use App\Models\Flottes\Vehicule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicle_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vehicule::class)->constrained()->cascadeOnDelete();

            $table->string('type')->comment('insurance, leasing, technical_control');
            $table->string('provider_name')->nullable()->comment('Ex: AXA, Dekra, Arval');
            $table->string('contract_number')->nullable();

            $table->decimal('cost_amount', 10, 2)->nullable();
            $table->string('cost_frequency')->nullable()->comment('monthly, annually, on_time');

            $table->date('started_at');
            $table->date('expires_at')->nullable()->comment('Date d\'échéance (pour alertes)');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_contracts');
    }
};
