<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('document_collections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            // --- Gestion des Droits (Phase 6) ---
            // [cite: Roadmap.md] "Droits d'accès granulaires"
            // Simplification: un dossier peut être privé ou public
            $table->boolean('is_public')->default(false);
            // On pourrait aussi lier à des `roles` ou `users`

            // Pour l'arborescence (Dossier parent)
            $table->foreignId('parent_id')->nullable()->constrained('document_collections')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_collections');
    }
};
