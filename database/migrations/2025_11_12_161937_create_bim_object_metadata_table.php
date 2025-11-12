<?php

use App\Models\Vision\BimModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bim_object_metadata', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BimModel::class)->constrained()->cascadeOnDelete();

            // L'identifiant unique de l'objet DANS la maquette
            $table->string('object_guid')->comment('GUID ou ID unique de l\'objet dans le fichier BIM');

            $table->string('object_type')->nullable()->comment('Ex: IfcWall, IfcDoor, IfcBeam');
            $table->string('name')->nullable();

            // Stockage des autres propriétés (dimensions, matériaux...)
            $table->json('properties')->nullable();
            $table->timestamps();

            $table->unique(['bim_model_id', 'object_guid']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bim_object_metadata');
    }
};
