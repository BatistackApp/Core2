<?php

namespace Database\Factories\Flottes;

use App\Models\Chantiers\Chantiers;
use App\Models\Flottes\VehicleTollLog;
use App\Models\Flottes\Vehicule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VehicleTollLogFactory extends Factory
{
    protected $model = VehicleTollLog::class;

    public function definition(): array
    {
        return [
            'transaction_date' => Carbon::now(),
            'amount' => $this->faker->randomFloat(),
            'peage' => $this->faker->word(),
            'direction' => $this->faker->word(),
            'provider' => $this->faker->word(),
            'provider_transaction_id' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'vehicule_id' => Vehicule::factory(),
            'chantiers_id' => Chantiers::factory(),
        ];
    }
}
