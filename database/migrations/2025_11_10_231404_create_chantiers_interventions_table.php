<?php

use App\Models\Chantiers\Chantiers;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chantiers_interventions', function (Blueprint $table) {
            $table->id();
            $table->date('date_intervention')->default(now());
            $table->text('description');
            $table->decimal('temps', 12, 2)->nullable();
            $table->boolean('facturable')->default(true);
            $table->foreignIdFor(Chantiers::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'intervenant_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chantiers_interventions');
    }
};
