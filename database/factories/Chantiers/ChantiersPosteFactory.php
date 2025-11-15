<?php

namespace Database\Factories\Chantiers;

use App\Models\Chantiers\Chantiers;
use App\Models\Chantiers\ChantiersPoste;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ChantiersPosteFactory extends Factory
{
    protected $model = ChantiersPoste::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->text(),
            'quantity' => $this->faker->randomFloat(),
            'unit' => $this->faker->word(),
            'unit_price_ht' => $this->faker->randomFloat(),
            'total_budget_amount' => $this->faker->randomFloat(),
            'current_progress_percentage' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'chantiers_id' => Chantiers::factory(),
        ];
    }
}
