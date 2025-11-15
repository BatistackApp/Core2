<?php

namespace Database\Factories\Paie;

use App\Models\Paie\PayrollComponent;
use App\Models\Paie\PayrollVariable;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PayrollVariableFactory extends Factory
{
    protected $model = PayrollVariable::class;

    public function definition(): array
    {
        return [
            'applicable_date' => Carbon::now(),
            'value' => $this->faker->randomFloat(),
            'unit' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'component_id' => PayrollComponent::factory(),
        ];
    }
}
