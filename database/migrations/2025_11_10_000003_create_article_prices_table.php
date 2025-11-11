<?php

use App\Models\Articles\Articles;
use App\Models\Tiers\Tiers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('article_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Articles::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Tiers::class)->nullable()->constrained()->cascadeOnDelete()->comment('Prix spécifique pour ce client');

            $table->string('price_level_name')->nullable();

            $table->decimal('min_quantity');
            $table->decimal('price_ht');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_prices');
    }
};
