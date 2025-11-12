<?php

namespace App\Models\Tiers;

use App\Models\Core\Bank;
use App\Observer\Tiers\TiersBankObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([TiersBankObserver::class])]
class TiersBank extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function tiers(): BelongsTo
    {
        return $this->belongsTo(Tiers::class);
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    protected function casts(): array
    {
        return [
            'default' => 'boolean',
            'iban' => 'encrypted',
        ];
    }
}
