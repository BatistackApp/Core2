<?php

use App\Models\NoteFrais\Expense;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expense_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Expense::class)->constrained()->cascadeOnDelete();
            $table->string('file_path')->comment('Chemin dans le stockage (S3, local...)');
            $table->string('filename');
            $table->string('mime_type')->nullable();
            $table->unsignedInteger('size')->nullable();

            // --- Champs pour l'OCR (Phase 5) ---
            $table->text('ocr_raw_text')->nullable();
            $table->decimal('ocr_detected_amount')->nullable();
            $table->date('ocr_detected_date')->nullable();
            $table->string('ocr_detected_merchant')->nullable();
            $table->string('ocr_status')->default('pending')->comment('pending, processed, failed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_receipts');
    }
};
