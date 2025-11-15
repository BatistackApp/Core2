<?php

namespace App\Models\Articles;

use App\Enums\Tiers\TiersType;
use App\Models\Tiers\Tiers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticlePrice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    public function articles(): BelongsTo
    {
        return $this->belongsTo(Articles::class);
    }

    public function tiers(): BelongsTo
    {
        return $this->belongsTo(Tiers::class);
    }

    protected $casts = [
        'price_level_name' => TiersType::class,
        'min_quantity' => 'decimal:2',
        'price_ht' => 'decimal:2',
    ];
}
