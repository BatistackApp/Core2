<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expense_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'manager_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title')->comment('Ex: Déplacement Paris Mars 2027');
            $table->string('status')->default('draft')->comment('draft, submitted, approved, rejected, reimbursed');
            $table->date('period_start_date')->nullable();
            $table->date('period_end_date')->nullable();
            $table->decimal('total_ht', 10, 2)->default(0);
            $table->decimal('total_ttc', 10, 2)->default(0);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('payed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_reports');
    }
};
