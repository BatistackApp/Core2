<?php

namespace App\Models\GPAO;

use App\Models\Articles\Articles;
use App\Observer\GPAO\ProductionOrderComponentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([ProductionOrderComponentObserver::class])]
class ProductionOrderComponent extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function productionOrder(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function articles(): BelongsTo
    {
        return $this->belongsTo(Articles::class);
    }

    protected $casts = [
        'quantity_required' => 'decimal:2',
        'quantity_consumed' => 'decimal:2',
        'unit_cost' => 'decimal:2',
    ];
}
