<?php

namespace App\Models\Articles;

use App\Observer\Articles\ArticleOuvrageObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([ArticleOuvrageObserver::class])]
class ArticleOuvrage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    /**
     * Définition des casts pour les attributs.
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
        ];
    }

    public function parentArticle(): BelongsTo
    {
        return $this->belongsTo(Articles::class, 'parent_article_id');
    }

    public function childArticle(): BelongsTo
    {
        return $this->belongsTo(Articles::class, 'child_article_id');
    }
}
