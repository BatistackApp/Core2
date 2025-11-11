<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nom complet (ex: Heure, Mètre linéaire, Pièce, Forfait)');
            $table->string('symbol')->comment('Symbole (ex: h, ml, pce, F)');
            $table->string('type')->nullable()->comment('Type d\'unité (ex: temps, longueur, surface, volume, comptage, forfait)');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
