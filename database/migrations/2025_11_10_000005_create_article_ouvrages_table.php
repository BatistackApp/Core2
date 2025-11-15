<?php

use App\Models\Articles\Articles;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('article_ouvrages', function (Blueprint $table) {
            $table->id();
            // L'article "parent" (l'Ouvrage, ex: "M² de mur")
            $table->foreignIdFor(Articles::class, 'parent_article_id')->constrained()->cascadeOnDelete();

            // L'article "enfant" (le composant, ex: "Parpaing")
            $table->foreignIdFor(Articles::class, 'child_article_id')->constrained()->cascadeOnDelete();

            // La quantité de "child" nécessaire pour 1 unité de "parent"
            $table->decimal('quantity');

            $table->unique(['parent_article_id', 'child_article_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_ouvrages');
    }
};
