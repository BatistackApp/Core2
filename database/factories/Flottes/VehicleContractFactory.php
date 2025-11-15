<?php

namespace Database\Factories\Flottes;

use App\Models\Flottes\VehicleContract;
use App\Models\Flottes\Vehicule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VehicleContractFactory extends Factory
{
    protected $model = VehicleContract::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->word(),
            'provider_name' => $this->faker->name(),
            'contract_number' => $this->faker->word(),
            'cost_amount' => $this->faker->randomFloat(),
            'cost_frequency' => $this->faker->word(),
            'started_at' => Carbon::now(),
            'expires_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'vehicule_id' => Vehicule::factory(),
        ];
    }
}
