<?php

use App\Models\Articles\Articles;
use App\Models\Articles\Inventory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventory_lines', function (Blueprint $table) {
            $table->id();
            $table->decimal('expected_quantity', 10, 2)->default(0);
            $table->decimal('real_quantity', 10, 2)->default(0);
            $table->string('location')->nullable()->comment('Emplacement dans l\'entrepôt');

            $table->foreignIdFor(Inventory::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Articles::class)->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['inventory_id', 'articles_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_lines');
    }
};
