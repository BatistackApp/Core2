<?php

use App\Models\Chantiers\Chantiers;
use App\Models\Tiers\Tiers;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->string('num_devis');
            $table->date('date_devis');
            $table->date('date_validate')->nullable();
            $table->string('status')->default('draft');
            $table->decimal('amount_ht', 20, 2);
            $table->decimal('amount_ttc', 20, 2);
            $table->longText('notes')->nullable();
            $table->foreignIdFor(Chantiers::class)->nullable();
            $table->foreignIdFor(Tiers::class)->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(User::class, 'responsable_id')->constrained()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};
