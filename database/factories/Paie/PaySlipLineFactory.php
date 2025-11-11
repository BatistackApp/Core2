<?php

namespace Database\Factories\Paie;

use App\Models\Paie\PaySlip;
use App\Models\Paie\PaySlipLine;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PaySlipLineFactory extends Factory
{
    protected $model = PaySlipLine::class;

    public function definition(): array
    {
        return [
            'component_code' => $this->faker->word(),
            'label' => $this->faker->word(),
            'type' => $this->faker->word(),
            'base_amount' => $this->faker->randomFloat(),
            'rate' => $this->faker->randomFloat(),
            'gain_amount' => $this->faker->randomFloat(),
            'deduction_amount' => $this->faker->randomFloat(),
            'employer_amount' => $this->faker->randomFloat(),
            'order' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'pay_slip_id' => PaySlip::factory(),
        ];
    }
}
