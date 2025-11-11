<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leave_entitlements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('year')->comment('Année de référence (ex: 2026)');
            $table->string('type')->comment('conges, rtt, maladie, injustifie');
            $table->decimal('total_allocated', 5, 2)->comment('Nb de jours alloués');
            $table->decimal('total_taken', 5, 2)->default(0)->comment('Nb de jours pris');

            // Solde = total_allocated - total_taken
            $table->timestamps();
            $table->unique(['user_id', 'year', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_entitlements');
    }
};
