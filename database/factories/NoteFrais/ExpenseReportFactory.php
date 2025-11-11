<?php

namespace Database\Factories\NoteFrais;

use App\Models\NoteFrais\ExpenseReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ExpenseReportFactory extends Factory
{
    protected $model = ExpenseReport::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'status' => $this->faker->word(),
            'period_start_date' => Carbon::now(),
            'period_end_date' => Carbon::now(),
            'total_ht' => $this->faker->randomFloat(),
            'total_ttc' => $this->faker->randomFloat(),
            'submitted_at' => Carbon::now(),
            'approved_at' => Carbon::now(),
            'rejected_at' => Carbon::now(),
            'payed_at' => Carbon::now(),
            'rejection_reason' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'manager_id' => User::factory(),
        ];
    }
}
