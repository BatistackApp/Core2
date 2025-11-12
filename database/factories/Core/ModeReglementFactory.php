<?php

namespace Database\Factories\Core;

use App\Models\Core\ModeReglement;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModeReglementFactory extends Factory
{
    protected $model = ModeReglement::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'name' => $this->faker->name(),
            'type_paiement' => $this->faker->words(),
            'bridgeable' => $this->faker->boolean(),
        ];
    }
}
