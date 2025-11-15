<?php

use App\Models\NoteFrais\ExpenseCategory;
use App\Models\NoteFrais\ExpenseReport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ExpenseReport::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ExpenseCategory::class)->constrained()->onDelete('restrict');
            $table->date('expense_date');
            $table->text('description');
            $table->decimal('amount_ht', 10, 2);
            $table->decimal('vat_rate', 5, 2)->nullable();
            $table->decimal('amount_vat', 10, 2)->nullable();
            $table->decimal('amount_ttc', 10, 2);
            $table->string('currency')->default('EUR');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
