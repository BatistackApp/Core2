<?php

use App\Models\Articles\ArticleCategory;
use App\Models\Articles\Unit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('reference')->nullable()->comment('SKU / Référence interne');
            $table->string('barcode')->nullable()->comment('EAN-13 / QR Code');

            $table->string('type_article')->default('material')->comment('material, service, labor, ouvrage, rental');

            $table->boolean('is_stock_managed')->default(false)->comment('True si type = material et stock suivi');
            $table->decimal('stock_alert_threshold', 10, 2)->nullable();

            $table->decimal('price_achat_ht', 10, 2)->nullable();
            $table->decimal('prix_vente_ht', 10, 2)->nullable();
            $table->decimal('vat_rate', 5, 2)->default(20.00);

            $table->boolean('is_active')->default(true);

            $table->foreignIdFor(Unit::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignIdFor(ArticleCategory::class)->nullable()->constrained()->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
