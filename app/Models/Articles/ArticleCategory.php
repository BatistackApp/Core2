<?php

namespace App\Models\Articles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    /**
     * Obtenir la catégorie parente (arborescence).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'parent_id');
    }

    /**
     * Obtenir les catégories enfants (arborescence).
     */
    public function children(): HasMany
    {
        return $this->hasMany(ArticleCategory::class, 'parent_id');
    }

    /**
     * Obtenir les articles de cette catégorie.
     * [cite: 2025_11_10_000002_create_articles_table.php]
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Articles::class);
    }
}
