<?php

namespace App\Models\Commerces;

use App\Enums\Commerces\StatusDevis;
use App\Models\Chantiers\Chantiers;
use App\Models\Tiers\Tiers;
use App\Models\User;
use App\Observer\Commerces\DevisObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([DevisObserver::class])]
class Devis extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function chantiers(): BelongsTo
    {
        return $this->belongsTo(Chantiers::class);
    }

    public function tiers(): BelongsTo
    {
        return $this->belongsTo(Tiers::class);
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function lines(): HasMany
    {
        return $this->hasMany(DevisLigne::class);
    }

    protected function casts(): array
    {
        return [
            'date_devis' => 'date',
            'date_validate' => 'date',
            'status' => StatusDevis::class,
        ];
    }
}
