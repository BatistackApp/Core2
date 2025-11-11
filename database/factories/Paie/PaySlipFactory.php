<?php

namespace Database\Factories\Paie;

use App\Models\Paie\PaySlip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PaySlipFactory extends Factory
{
    protected $model = PaySlip::class;

    public function definition(): array
    {
        return [
            'period_year' => $this->faker->word(),
            'period_month' => $this->faker->word(),
            'period_start_at' => Carbon::now(),
            'period_end_at' => Carbon::now(),
            'status' => $this->faker->word(),
            'total_gross_salary' => $this->faker->randomFloat(),
            'total_salary_deductions' => $this->faker->randomFloat(),
            'total_employer_contributions' => $this->faker->randomFloat(),
            'net_salary' => $this->faker->randomFloat(),
            'net_payable' => $this->faker->randomFloat(),
            'document_path' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
