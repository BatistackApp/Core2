<?php

use App\Models\Facturation\Facture;
use App\Models\Facturation\Payment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('facture_payment', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Facture::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Payment::class)->constrained()->cascadeOnDelete();
            $table->decimal('amount_applied', 10, 2);
            $table->timestamps();
            $table->unique(['facture_id', 'payment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facture_payment');
    }
};
