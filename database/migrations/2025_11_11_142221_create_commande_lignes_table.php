<?php

use App\Models\Commerces\Commande;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commande_lignes', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('libelle');
            $table->text('description')->nullable();
            $table->decimal('qte');
            $table->decimal('puht');
            $table->decimal('amount_ht');
            $table->decimal('tva_rate');
            $table->foreignIdFor(Commande::class)->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commande_lignes');
    }
};
