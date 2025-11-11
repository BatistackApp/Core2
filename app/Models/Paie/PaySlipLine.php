<?php

namespace App\Models\Paie;

use App\Enums\Paie\PayrollComponentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaySlipLine extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function paySlip(): BelongsTo
    {
        return $this->belongsTo(PaySlip::class);
    }

    protected $casts = [
        'type' => PayrollComponentType::class, // Cast vers l'Enum (snapshot du type)
        'base_amount' => 'decimal:2',
        'rate' => 'decimal:4',
        'gain_amount' => 'decimal:2',
        'deduction_amount' => 'decimal:2',
        'employer_amount' => 'decimal:2',
        'order' => 'integer',
    ];
}
