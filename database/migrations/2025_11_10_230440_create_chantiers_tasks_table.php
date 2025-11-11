<?php

use App\Models\Chantiers\Chantiers;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chantiers_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->text('description')->nullable();
            $table->date('date_debut_prevu');
            $table->date('date_fin_prevue');
            $table->date('date_debut_reel')->nullable();
            $table->date('date_fin_reel')->nullable();
            $table->string('status');
            $table->string('priority');
            $table->foreignIdFor(User::class, 'assigned_id')->nullable();
            $table->foreignIdFor(Chantiers::class)->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chantiers_tasks');
    }
};
