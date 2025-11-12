<?php

use App\Models\Vision\BimModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bim_links', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BimModel::class, 'bim_object_id')->constrained()->cascadeOnDelete();

            // L'objet Métier (Polymorphique)
            $table->morphs('linkable'); // ex: ChantierTask, ChantierPoste

            $table->timestamps();

            $table->unique(['bim_object_id', 'linkable_id', 'linkable_type'], 'bim_link_unique_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bim_links');
    }
};
