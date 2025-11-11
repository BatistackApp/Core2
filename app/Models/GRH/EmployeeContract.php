<?php

namespace App\Models\GRH;

use App\Enums\GRH\ContractType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeContract extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'start_at' => 'date',
            'end_at' => 'date',
            'is_active' => 'boolean',
            'contract_type' => ContractType::class,
            'base_salary' => 'decimal:2',
            'weekly_hours' => 'decimal:2',
        ];
    }
}
