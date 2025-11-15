<?php

namespace Database\Factories\Facturation;

use App\Models\Facturation\FactureRecurring;
use App\Models\Tiers\Tiers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FactureRecurringFactory extends Factory
{
    protected $model = FactureRecurring::class;

    public function definition(): array
    {
        return [
            'status' => $this->faker->word(),
            'frequency' => $this->faker->word(),
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now(),
            'last_generated_at' => Carbon::now(),
            'next_generation_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'tiers_id' => Tiers::factory(),
        ];
    }
}
