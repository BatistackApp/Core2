<?php

namespace Database\Factories\NoteFrais;

use App\Models\Comptabilite\PlanComptable;
use App\Models\NoteFrais\ExpenseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseCategoryFactory extends Factory
{
    protected $model = ExpenseCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->word(),
            'requires_receipt' => $this->faker->boolean(),
            'is_active' => $this->faker->boolean(),

            'plan_comptable_id' => PlanComptable::factory(),
        ];
    }
}
