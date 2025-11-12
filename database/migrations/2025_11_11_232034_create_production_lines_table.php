<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('production_lines', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Ex: "ATELIER_DECOUPE", "PRESSE_PLIEUSE"
            $table->string('name'); // Ex: "Atelier Découpe Bois", "Presse Plieuse CNC"
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_lines');
    }
};
