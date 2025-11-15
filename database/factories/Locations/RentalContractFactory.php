<?php

namespace Database\Factories\Locations;

use App\Models\Chantiers\Chantiers;
use App\Models\Locations\RentalContract;
use App\Models\Tiers\Tiers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RentalContractFactory extends Factory
{
    protected $model = RentalContract::class;

    public function definition(): array
    {
        return [
            'number' => $this->faker->word(),
            'status' => $this->faker->word(),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'billing_frequency' => $this->faker->word(),
            'last_billed_at' => Carbon::now(),
            'total_amount' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'tiers_id' => Tiers::factory(),
            'chantiers_id' => Chantiers::factory(),
        ];
    }
}
