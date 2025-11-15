<?php

namespace Database\Factories\NoteFrais;

use App\Models\NoteFrais\Expense;
use App\Models\NoteFrais\ExpenseCategory;
use App\Models\NoteFrais\ExpenseReport;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'expense_date' => Carbon::now(),
            'description' => $this->faker->text(),
            'amount_ht' => $this->faker->randomFloat(),
            'vat_rate' => $this->faker->randomFloat(),
            'amount_vat' => $this->faker->randomFloat(),
            'amount_ttc' => $this->faker->randomFloat(),
            'currency' => $this->faker->word(),
            'notes' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'expense_report_id' => ExpenseReport::factory(),
            'expense_category_id' => ExpenseCategory::factory(),
        ];
    }
}
