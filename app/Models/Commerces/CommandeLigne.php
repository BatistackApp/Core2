<?php

namespace App\Models\Commerces;

use App\Enums\Commerces\TypeDevisLigne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommandeLigne extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }

    protected $casts = [
        'type' => TypeDevisLigne::class,
    ];
}
