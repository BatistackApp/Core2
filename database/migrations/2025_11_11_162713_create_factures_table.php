<?php

use App\Models\Chantiers\Chantiers;
use App\Models\Commerces\Commande;
use App\Models\Tiers\Tiers;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('num_facture')->comment('Numéro de facture (ex: FA-2026-0001)');
            $table->string('status')->default('draft')->comment('draft, sent, paid, partially_paid, overdue, cancelled');
            $table->string('type_facture')->default('standard')->comment('standard, down_payment, credit_note, work_situation, final_settlement');
            $table->date('date_facture');
            $table->date('date_echue');
            $table->date('situation_started_at')->nullable()->comment('Date de début de la période de situation');
            $table->date('situtation_ended_at')->nullable()->comment('Date de fin de la période de situation');
            $table->decimal('progress_percentage')->nullable()->comment('Avancement global pondéré');
            $table->decimal('total_work_to_date')->nullable()->comment('Montant total de l\'avancement à date');
            $table->decimal('previous_situations_total')->nullable()->comment('Montant cumulé des situations N-1');
            $table->decimal('guarantee_retention_percentage')->nullable()->comment('Taux de RG appliqué (snapshot)');
            $table->decimal('guarantee_retention_amount')->nullable()->comment('Montant RG (calculé depuis les lignes HT)');
            $table->boolean('guarantee_released')->default(false)->comment('Si la RG a été levée/facturée');
            $table->decimal('amount_ht', 10, 2);
            $table->decimal('amount_tva', 10, 2);
            $table->decimal('amount_ttc', 10, 2);
            $table->longText('notes')->nullable();
            $table->string('pdf_path')->nullable();

            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignIdFor(Tiers::class)->constrained()->onDelete('restrict');
            $table->foreignIdFor(Chantiers::class)->nullable()->constrained()->onDelete('restrict');
            $table->foreignIdFor(Commande::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignIdFor(\App\Models\Facturation\Facture::class, 'parent_facture_id')->nullable()->constrained('factures')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['num_facture']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
