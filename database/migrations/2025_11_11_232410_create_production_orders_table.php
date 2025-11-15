<?php

use App\Models\Articles\Articles;
use App\Models\Chantiers\Chantiers;
use App\Models\Commerces\Commande;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('production_orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique(); // Ex: "OF-2027-0001"

            // Quoi produire ? (L'article "Ouvrage" / "Compound")
            $table->foreignIdFor(Articles::class)->constrained()->onDelete('restrict');

            $table->decimal('quantity_to_produce', 10, 2);
            $table->decimal('quantity_produced', 10, 2)->default(0);

            // Liens optionnels
            $table->foreignIdFor(Chantiers::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignIdFor(Commande::class)->nullable()->constrained()->onDelete('set null');

            // Planification
            $table->date('due_date')->comment('Date de fin de production souhaitée');
            $table->timestamp('started_at')->nullable()->comment('Début réel');
            $table->timestamp('completed_at')->nullable()->comment('Fin réelle');
            $table->string('status')->default('draft')->comment('draft, planned, in_progress, completed, cancelled');

            // Coûts (calculés depuis les composants et opérations)
            $table->decimal('estimated_coast')->nullable();
            $table->decimal('actual_coast')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_orders');
    }
};
