<?php

namespace App\Models\Articles;

use App\Enums\Articles\ArticleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articles extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function articleCategory(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    /**
     * Obtenir les prix spécifiques (multi-niveaux).
     * [cite: 2025_11_10_000003_create_article_prices_table.php]
     */
    public function prices(): HasMany
    {
        return $this->hasMany(ArticlePrice::class, 'articles_id');
    }

    /**
     * Obtenir les stocks dans différents entrepôts.
     * [cite: 2025_11_10_000004_create_article_stocks_table.php]
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(ArticleStock::class, 'articles_id');
    }

    /**
     * Obtenir les composants (si c'est un Ouvrage / 'ouvrage').
     * [cite: 2025_11_10_000005_create_article_ouvrages_table.php]
     */
    public function components(): HasMany
    {
        return $this->hasMany(ArticleOuvrage::class, 'parent_article_id');
    }

    /**
     * Obtenir les ouvrages parents où cet article est utilisé comme composant.
     * [cite: 2025_11_10_000005_create_article_ouvrages_table.php]
     */
    public function parentOuvrages(): HasMany
    {
        return $this->hasMany(ArticleOuvrage::class, 'child_article_id');
    }

    protected function casts(): array
    {
        return [
            'type_article' => ArticleType::class, // Cast vers l'Enum
            'is_stock_managed' => 'boolean',
            'stock_alert_threshold' => 'decimal:2',
            'price_achat_ht' => 'decimal:2',
            'prix_vente_ht' => 'decimal:2',
            'vat_rate' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
