<?php

namespace Database\Factories\GRH;

use App\Models\GRH\EmployeeContract;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EmployeeContractFactory extends Factory
{
    protected $model = EmployeeContract::class;

    public function definition(): array
    {
        return [
            'contract_type' => $this->faker->word(),
            'job_title' => $this->faker->word(),
            'job_description' => $this->faker->text(),
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now(),
            'base_salary' => $this->faker->randomFloat(),
            'salary_period' => $this->faker->word(),
            'weekly_hours' => $this->faker->randomFloat(),
            'is_active' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
