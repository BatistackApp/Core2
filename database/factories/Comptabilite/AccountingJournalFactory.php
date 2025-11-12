<?php

namespace Database\Factories\Comptabilite;

use App\Models\Comptabilite\AccountingJournal;
use App\Models\Comptabilite\PlanComptable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AccountingJournalFactory extends Factory
{
    protected $model = AccountingJournal::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'name' => $this->faker->name(),
            'type' => $this->faker->word(),
            'is_active' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'plan_comptable_id' => PlanComptable::factory(),
        ];
    }
}
