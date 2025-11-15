<?php

namespace Database\Factories\Locations;

use App\Models\Locations\RentalContract;
use App\Models\Locations\RentalContractLine;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RentalContractLineFactory extends Factory
{
    protected $model = RentalContractLine::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->text(),
            'quantity' => $this->faker->randomFloat(),
            'unit_price' => $this->faker->randomFloat(),
            'price_unit' => $this->faker->word(),
            'total_line_amount' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'rental_contract_id' => RentalContract::factory(),
        ];
    }
}
