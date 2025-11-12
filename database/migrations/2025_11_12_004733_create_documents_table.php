<?php

use App\Models\GED\DocumentCollection;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('set null');

            // Dossier de rangement
            $table->foreignIdFor(DocumentCollection::class)->nullable()->constrained()->onDelete('set null');

            // --- Relation Polymorphique Clé ---
            // C'est ce qui lie le document à un Chantier, une Facture, un Employé...
            $table->morphs('documentable'); // Crée `documentable_id` et `documentable_type`

            $table->string('name')->comment('Nom d\'affichage (ex: Plan RDC V2)');
            $table->string('status')->default('active')->comment('active, archived, draft');

            // --- Métadonnées du Fichier (de la version actuelle) ---
            // [cite: Roadmap.md] "Versionnement des documents"
            $table->string('current_file_path')->comment('Chemin vers la version actuelle du fichier');
            $table->string('current_filename');
            $table->string('current_mime_type')->nullable();
            $table->unsignedInteger('current_size')->nullable();
            $table->unsignedInteger('current_version_number')->default(1);

            // --- Métadonnées pour la Signature (Phase 6) ---
            // [cite: Roadmap.md] "Intégration avec GED"
            $table->boolean('is_signed');
            $table->timestamp('signed_at')->nullable();
            $table->timestamps();

            $table->index(['documentable_id', 'documentable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
