<?php

namespace App\Models\Articles;

use App\Models\Core\Warehouse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleStock extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    public function articles(): BelongsTo
    {
        return $this->belongsTo(Articles::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
