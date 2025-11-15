<?php

namespace App\Models\Facturation;

use App\Enums\Facturation\StatusFacture;
use App\Enums\Facturation\TypeFacture;
use App\Models\Chantiers\Chantiers;
use App\Models\Commerces\Commande;
use App\Models\Tiers\Tiers;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facture extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tiers(): BelongsTo
    {
        return $this->belongsTo(Tiers::class);
    }

    public function chantiers(): BelongsTo
    {
        return $this->belongsTo(Chantiers::class);
    }

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Facture::class, 'parent_id');
    }

    public function creditNotes(): HasMany
    {
        return $this->hasMany(Facture::class, 'parent_id');
    }

    public function lines(): HasMany
    {
        return $this->hasMany(FactureLigne::class);
    }

    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class, 'amount_applied');
    }

    protected function casts(): array
    {
        return [
            'date_facture' => 'date',
            'date_echue' => 'date',
            'situation_started_at' => 'date',
            'situtation_ended_at' => 'date',
            'guarantee_released' => 'boolean',
            'status' => StatusFacture::class,
            'type_facture' => TypeFacture::class,
        ];
    }
}
