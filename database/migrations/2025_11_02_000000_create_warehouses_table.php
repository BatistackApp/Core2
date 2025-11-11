<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('code_postal');
            $table->string('ville');
            $table->string('pays');
            $table->boolean('is_default')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
