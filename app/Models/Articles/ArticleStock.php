<?php

namespace App\Models\Articles;

use App\Models\Core\Warehouse;
use App\Observer\Articles\ArticleStockObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([ArticleStockObserver::class])]
class ArticleStock extends Model
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
            'quantity_reserved' => 'decimal:2',
        ];
    }

    public function articles(): BelongsTo
    {
        return $this->belongsTo(Articles::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
