<?php

use App\Models\Chantiers\Chantiers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chantiers_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('code_postal');
            $table->string('ville');
            $table->string('pays');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->foreignIdFor(Chantiers::class)->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chantiers_addresses');
    }
};
