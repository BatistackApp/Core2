<?php

namespace Database\Factories\Locations;

use App\Models\Locations\RentalAvailability;
use App\Models\Locations\RentalContract;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RentalAvailabilityFactory extends Factory
{
    protected $model = RentalAvailability::class;

    public function definition(): array
    {
        return [
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'quantity_reserved' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'rental_contract_id' => RentalContract::factory(),
        ];
    }
}
