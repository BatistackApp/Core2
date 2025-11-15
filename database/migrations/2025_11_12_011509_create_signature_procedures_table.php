<?php

use App\Models\GED\Document;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('signature_procedures', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Document::class)->constrained()->cascadeOnDelete();

            $table->string('subject')->nullable();
            $table->text('message')->nullable();

            // draft, sent, completed, cancelled, expired
            $table->string('status')->default('draft');

            // Si coché, l'ordre des signataires (order) est respecté
            $table->boolean('ordering_enabled')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signature_procedures');
    }
};
