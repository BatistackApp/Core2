<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employee_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('name')->comment('Ex: CACES R482, Habilitation Électrique B2V');
            $table->string('issued_by')->nullable()->comment('Organisme de formation');
            $table->date('issued_at');
            $table->date('expired_at')->nullable()->comment("Date d'expiration (si applicable)");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_qualifications');
    }
};
