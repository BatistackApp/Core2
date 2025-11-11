<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employee_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->unique()->constrained()->cascadeOnDelete();
            $table->string('social_security_number')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('nationnality')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('ville')->nullable();
            $table->string('pays')->nullable();
            $table->date('hired_at');
            $table->date('left_at')->nullable();
            $table->string('bank_iban')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_profiles');
    }
};
