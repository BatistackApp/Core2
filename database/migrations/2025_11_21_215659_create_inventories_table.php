<?php

use App\Models\Core\Warehouse;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('Référence unique (ex: INV-2025-001)');
            $table->date('inventory_date')->comment('Date de comptage');

            // Statut : 'draft' (brouillon), 'validated' (appliqué)
            $table->string('status');

            $table->text('comment')->nullable();
            $table->timestamp('validated_at')->nullable();

            $table->foreignIdFor(Warehouse::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
