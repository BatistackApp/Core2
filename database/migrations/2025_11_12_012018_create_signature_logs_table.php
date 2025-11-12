<?php

use App\Models\Signature\SignatureProcedure;
use App\Models\Signature\SignatureSigner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('signature_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SignatureProcedure::class, 'procedure_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(SignatureSigner::class, 'signer_id')->nullable()->constrained()->onDelete('set null');

            // procedure_created, email_sent, document_viewed, document_signed, procedure_completed
            $table->string('event_type');
            $table->ipAddress()->nullable();
            $table->text('user_agent')->nullable();
            $table->text('detail')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signature_logs');
    }
};
