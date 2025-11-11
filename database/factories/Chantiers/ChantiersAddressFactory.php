<?php

namespace Database\Factories\Chantiers;

use App\Models\Chantiers\Chantiers;
use App\Models\Chantiers\ChantiersAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChantiersAddressFactory extends Factory
{
    protected $model = ChantiersAddress::class;

    public function definition(): array
    {
        return [
            'address' => $this->faker->address(),
            'code_postal' => $this->faker->postcode(),
            'ville' => $this->faker->city,
            'pays' => $this->faker->country,
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),

            'chantiers_id' => Chantiers::factory(),
        ];
    }
}
