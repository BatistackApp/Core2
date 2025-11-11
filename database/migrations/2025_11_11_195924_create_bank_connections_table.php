<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bank_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade');
            $table->string('bridge_item_id')->comment('ID de l\'item/connexion chez le provider');
            $table->string('status')->default('active')->comment('active, disconnected, error');
            $table->timestamp('last_synced_at')->nullable();
            // Stockage sécurisé des credentials (si nécessaire, chiffré)
            $table->text('credentials')->nullable();

            $table->timestamps();

            $table->unique(['bridge_item_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_connections');
    }
};
