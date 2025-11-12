<?php

namespace Database\Factories\Flottes;

use App\Models\Flottes\Vehicule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VehiculeFactory extends Factory
{
    protected $model = Vehicule::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'plate_number' => $this->faker->word(),
            'vin_number' => $this->faker->word(),
            'brand' => $this->faker->word(),
            'model' => $this->faker->word(),
            'type' => $this->faker->word(),
            'status' => $this->faker->word(),
            'purchased_at' => Carbon::now(),
            'purchase_price' => $this->faker->randomFloat(),
            'toll_badge_number' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
