<?php

namespace App\Models\Paie;

use App\Enums\Paie\PayrollVariableUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollVariable extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(PayrollComponent::class, 'component_id');
    }

    protected function casts(): array
    {
        return [
            'applicable_date' => 'date',
            'value' => 'decimal:2',
            'unit' => PayrollVariableUnit::class,
        ];
    }
}
