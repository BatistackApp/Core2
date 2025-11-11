<?php

namespace App\Models\Facturation;

use App\Enums\Facturation\StatusPayment;
use App\Models\Core\ModeReglement;
use App\Models\Tiers\Tiers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tiers(): BelongsTo
    {
        return $this->belongsTo(Tiers::class);
    }

    public function modeReglement(): BelongsTo
    {
        return $this->belongsTo(ModeReglement::class);
    }

    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Facture::class)->withPivot('amount_applied');
    }

    protected function casts(): array
    {
        return [
            'paid_at' => 'date',
            'status' => StatusPayment::class,
        ];
    }
}
