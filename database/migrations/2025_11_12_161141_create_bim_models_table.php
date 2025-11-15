<?php

use App\Models\Chantiers\Chantiers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bim_models', function (Blueprint $table) {
            $table->id();
            // Lien 1-1 ou 1-N avec le chantier
            $table->foreignIdFor(Chantiers::class)->constrained()->cascadeOnDelete();

            $table->string('name')->comment('Ex: Maquette RDC, Structure Béton');

            // --- Fichier Source (l'original) ---
            $table->string('source_file_path'); // Chemin vers le .ifc, .rvt
            $table->string('source_file_type')->comment('ifc, rvt, skp...');

            $table->string('web_viewable_file_path')->nullable()->comment('Chemin vers le .glb / .gltf');

            $table->string('processing_status')->default('pending')->comment('pending, processing, completed, failed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bim_models');
    }
};
