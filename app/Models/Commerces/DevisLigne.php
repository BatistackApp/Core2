<?php

namespace App\Models\Commerces;

use App\Enums\Commerces\TypeDevisLigne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevisLigne extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function devis(): BelongsTo
    {
        return $this->belongsTo(Devis::class);
    }

    protected $casts = [
        'type' => TypeDevisLigne::class,
    ];
}
