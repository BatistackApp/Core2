<?php

namespace App\Models\Paie;

use App\Enums\Paie\PayrollCalculationMethod;
use App\Enums\Paie\PayrollComponentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollComponent extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'type' => PayrollComponentType::class, // Cast vers l'Enum
            'calculation_method' => PayrollCalculationMethod::class, // Cast vers l'Enum
            'rate' => 'decimal:4',
            'fixed_amount' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
