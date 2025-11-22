<?php

namespace App\Models\Articles;

use App\Enums\Articles\ArticleType;
use App\Enums\Commerces\StatusCommande;
use App\Enums\Tiers\TiersNature;
use App\Models\Commerces\CommandeLigne;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articles extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $appends = ['stock_status'];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category_id');
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

    public function commandeLignes(): HasMany
    {
        return $this->hasMany(CommandeLigne::class, 'articles_id');
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

    public function calculateStockAtDate($date): float
    {
        $targetDate = Carbon::parse($date);
        $currentStock = $this->stocks()->sum('quantity');

        $incoming = $this->commandeLignes()
            ->whereHas('commande', function ($query) use ($targetDate) {
                $query->where('commande.tiers.nature', TiersNature::Fournisseur)
                    ->where('commande.status', StatusCommande::CONFIRMED)
                    ->where('commande.date_livraison', '>', now())
                    ->where('commande.date_livraison', '<=', $targetDate);
            })
            ->sum('quantity');

        $outgoing = $this->commandeLignes()
            ->whereHas('commande', function ($query) use ($targetDate) {
                $query->where('commande.tiers.nature', TiersNature::Client)
                    ->whereIn('commande.status', [StatusCommande::CONFIRMED, StatusCommande::WAITING])
                    ->where('commande.date_livraison', '>', now())
                    ->where('commande.date_livraison', '<=', $targetDate);
            })
            ->sum('quantity');

        return $currentStock + $incoming - $outgoing;
    }

    protected function stockStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                $actual_stock = $this->stocks()->sum('quantity') - $this->stocks()->sum('quantity_reserved');
                $limit_quantity = $this->stock_alert_threshold;
                if ($actual_stock <= 0) {
                    return 'no_stock';
                } elseif ($actual_stock <= $limit_quantity) {
                    return 'stock_alert';
                } else {
                    return 'stock';
                }
            }
        );
    }
}
