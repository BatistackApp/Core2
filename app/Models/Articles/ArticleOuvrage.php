<?php

namespace App\Models\Articles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleOuvrage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    public function parentArticle(): BelongsTo
    {
        return $this->belongsTo(Articles::class, 'parent_article_id');
    }

    public function childArticle(): BelongsTo
    {
        return $this->belongsTo(Articles::class, 'child_article_id');
    }
}
