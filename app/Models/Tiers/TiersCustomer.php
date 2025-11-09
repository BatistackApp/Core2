<?php

namespace App\Models\Tiers;

use App\Models\Comptabilite\PlanComptable;
use App\Models\Core\ConditionReglement;
use App\Models\Core\ModeReglement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TiersCustomer extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function comptaGen(): BelongsTo
    {
        return $this->belongsTo(PlanComptable::class, 'code_comptable_general', 'id');
    }

    public function comptaClient(): BelongsTo
    {
        return $this->belongsTo(PlanComptable::class, 'code_comptable_client', 'id');
    }

    public function tiers(): BelongsTo
    {
        return $this->belongsTo(Tiers::class);
    }

    public function conditionReglement(): BelongsTo
    {
        return $this->belongsTo(ConditionReglement::class);
    }

    public function modeReglement(): BelongsTo
    {
        return $this->belongsTo(ModeReglement::class);
    }

    protected function casts(): array
    {
        return [
            'tva' => 'boolean',
        ];
    }
}
