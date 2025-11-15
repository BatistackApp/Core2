<?php

namespace App\Models\Articles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    /**
     * Obtenir les articles qui utilisent cette unité.
     * [cite: 2025_11_10_000002_create_articles_table.php]
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Articles::class);
    }
}
