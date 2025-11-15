<?php

namespace Database\Factories\Paie;

use App\Models\Paie\PayrollComponent;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayrollComponentFactory extends Factory
{
    protected $model = PayrollComponent::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'name' => $this->faker->name(),
            'type' => $this->faker->word(),
            'calculation_method' => $this->faker->word(),
            'rate' => $this->faker->randomFloat(),
            'fixed_amount' => $this->faker->randomFloat(),
            'base_component_code' => $this->faker->word(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
