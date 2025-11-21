<?php

namespace App\Models\Articles;

use App\Jobs\Articles\ValidateInventoryJob;
use App\Models\Core\Warehouse;
use App\Models\User;
use App\Observer\Articles\InventoryObserver;
use DB;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([InventoryObserver::class])]
class Inventory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(InventoryLine::class);
    }

    protected function casts(): array
    {
        return [
            'inventory_date' => 'date',
            'validated_at' => 'datetime',
        ];
    }

    /**
     * Valide l'inventaire et met à jour les stocks.
     */
    public function validateInventory(): void
    {
        if ($this->status === 'validated') {
            return;
        }

        $this->update(['status' => 'processing']);

        ValidateInventoryJob::dispatch($this);

    }
}
