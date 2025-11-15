<?php

use App\Models\Signature\SignatureProcedure;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('signature_signers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SignatureProcedure::class, 'procedure_id')->constrained()->cascadeOnDelete();

            $table->string('email');
            $table->string('name');

            // pending, sent, viewed, signed, refused
            $table->string('status')->default('pending');
            $table->integer('order');
            $table->string('token');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signature_signers');
    }
};
