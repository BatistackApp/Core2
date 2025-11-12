<?php

namespace Database\Factories\Locations;

use App\Models\Locations\RentalContract;
use App\Models\Locations\RentalReturn;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RentalReturnFactory extends Factory
{
    protected $model = RentalReturn::class;

    public function definition(): array
    {
        return [
            'returned_at' => Carbon::now(),
            'condition_notes' => $this->faker->word(),
            'additional_costs' => $this->faker->randomFloat(),
            'additional_costs_notes' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'rental_contract_id' => RentalContract::factory(),
            'user_id' => User::factory(),
        ];
    }
}
