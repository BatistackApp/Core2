<?php

namespace App\Models\Articles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    protected function casts(): array
    {
        return [
            'is_stock_managed' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}
