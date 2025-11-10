<?php

namespace App\Models\Chantiers;

use App\Enums\Chantiers\StatusChantiers;
use App\Models\Tiers\Tiers;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chantiers extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tiers(): BelongsTo
    {
        return $this->belongsTo(Tiers::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin_prevu' => 'date',
            'date_fin_reel' => 'date',
            'status' => StatusChantiers::class,
        ];
    }
}
