<?php

use App\Models\Articles\Articles;
use App\Models\GPAO\ProductionOrder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('production_order_components', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProductionOrder::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Articles::class)->constrained()->onDelete('restrict');
            $table->decimal('quantity_required', 10, 2);
            $table->decimal('quantity_consumed', 10, 2)->default(0);
            $table->string('unit_cost', 10, 2)->nullable()->comment('Coût unitaire du composant');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_order_components');
    }
};
