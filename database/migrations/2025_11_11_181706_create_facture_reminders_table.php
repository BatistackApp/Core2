<?php

use App\Models\Facturation\Facture;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('facture_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Facture::class)->constrained()->cascadeOnDelete();
            $table->integer('level');
            $table->string('status');
            $table->timestamp('send_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facture_reminders');
    }
};
