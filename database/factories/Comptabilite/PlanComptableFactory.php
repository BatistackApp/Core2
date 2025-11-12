<?php

namespace Database\Factories\Comptabilite;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comptabilite\PlanComptable>
 */
class PlanComptableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "code" => fake()->numberBetween(),
            "account" => "Comptes",
            "type" => "Fonds propres",
            "lettrage" => fake()->boolean(),
            "principal" => fake()->numberBetween(1,9),
            "initial" => fake()->randomFloat(2),
        ];
    }
}
