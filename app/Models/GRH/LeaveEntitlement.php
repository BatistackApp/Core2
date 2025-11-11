<?php

namespace App\Models\GRH;

use App\Enums\GRH\TypeLeaveEntitlements;
use App\Models\User;
use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Zap\Models\Concerns\HasSchedules;

class LeaveEntitlement extends Model
{
    use HasFactory, HasSchedules;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Accessor pour calculer le solde restant.
     */
    protected function balance(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                $attributes['total_allocated'] - $attributes['total_taken']
        );
    }


    protected $casts = [
        'type' => TypeLeaveEntitlements::class,
        'total_allocated' => 'decimal:2',
        'total_taken' => 'decimal:2',
    ];
}
