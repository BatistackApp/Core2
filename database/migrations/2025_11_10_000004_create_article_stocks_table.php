<?php

use App\Models\Articles\Articles;
use App\Models\Core\Warehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('article_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Articles::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Warehouse::class)->constrained()->cascadeOnDelete();

            $table->decimal('quantity', 10, 2)->default(0)->comment('Stock physique');
            $table->decimal('quantity_reserved', 10, 2)->default(0)->comment("Réserver pour chantier");

            $table->unique(['articles_id', 'warehouse_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_stocks');
    }
};
