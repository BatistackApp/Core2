<?php

namespace Database\Factories\Core;

use App\Models\Core\ConditionReglement;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionReglementFactory extends Factory
{
    protected $model = ConditionReglement::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'name' => $this->faker->name(),
            'name_document' => $this->faker->name(),
            'nb_jours' => $this->faker->randomNumber(),
            'fdm' => $this->faker->boolean(),
        ];
    }
}
