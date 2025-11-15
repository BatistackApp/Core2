<?php

namespace Database\Factories\Comptabilite;

use App\Models\Comptabilite\AccountingEntry;
use App\Models\Comptabilite\AccountingEntryLine;
use App\Models\Comptabilite\PlanComptable;
use App\Models\Tiers\Tiers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AccountingEntryLineFactory extends Factory
{
    protected $model = AccountingEntryLine::class;

    public function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'debit' => $this->faker->randomFloat(),
            'credit' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'entry_id' => AccountingEntry::factory(),
            'plan_comptable_id' => PlanComptable::factory(),
            'tiers_id' => Tiers::factory(),
        ];
    }
}
