<?php

namespace App\Models\Paie;

use App\Enums\Paie\PaySlipStatus;
use App\Models\GRH\EmployeeContract;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaySlip extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir le contrat (snapshot) utilisé pour ce bulletin.
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(EmployeeContract::class, 'employee_contract_id');
    }

    /**
     * Obtenir les lignes de calcul de ce bulletin.
     */
    public function lines(): HasMany
    {
        return $this->hasMany(PaySlipLine::class);
    }

    protected function casts(): array
    {
        return [
            'period_start_date' => 'date',
            'period_end_date' => 'date',
            'status' => PaySlipStatus::class, // Cast vers l'Enum
            'total_gross_salary' => 'decimal:2',
            'total_salary_deductions' => 'decimal:2',
            'total_employer_contributions' => 'decimal:2',
            'net_salary' => 'decimal:2',
            'net_payable' => 'decimal:2',
        ];
    }
}
