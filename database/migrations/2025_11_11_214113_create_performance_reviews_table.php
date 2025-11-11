<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade')->comment('Employé évalué');
            $table->foreignIdFor(User::class, 'reviewer_id')->constrained('users')->onDelete('cascade')->comment('Manager/Évaluateur');
            $table->date('review_date');
            $table->integer('rating')->nullable()->comment('Note (ex: 1 à 5)');
            $table->text('strengths')->nullable();
            $table->text('weaknesses')->nullable();
            $table->text('goals')->nullable()->comment('Objectifs pour l\'année suivante');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};
