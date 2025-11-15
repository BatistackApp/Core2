<?php

namespace App\Models\NoteFrais;

use App\Models\Comptabilite\PlanComptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    public function planComptable(): BelongsTo
    {
        return $this->belongsTo(PlanComptable::class);
    }

    /**
     * Obtenir les dépenses (lignes) associées à cette catégorie.
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    protected function casts(): array
    {
        return [
            'requires_receipt' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}
