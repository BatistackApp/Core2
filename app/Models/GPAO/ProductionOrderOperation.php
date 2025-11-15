<?php

namespace App\Models\GPAO;

use App\Models\User;
use App\Observer\GPAO\ProductionOrderOperationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([ProductionOrderOperationObserver::class])]
class ProductionOrderOperation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function productionOrder(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function productionLine(): BelongsTo
    {
        return $this->belongsTo(ProductionLine::class);
    }

    protected function casts(): array
    {
        return [
            'time_spent_hours' => 'decimal:2',
            'hourly_cost' => 'decimal:2',
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }
}
