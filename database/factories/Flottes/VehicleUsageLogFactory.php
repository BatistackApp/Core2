<?php

namespace Database\Factories\Flottes;

use App\Models\Chantiers\Chantiers;
use App\Models\Flottes\VehicleUsageLog;
use App\Models\Flottes\Vehicule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VehicleUsageLogFactory extends Factory
{
    protected $model = VehicleUsageLog::class;

    public function definition(): array
    {
        return [
            'log_date' => Carbon::now(),
            'mileage_start' => $this->faker->randomNumber(),
            'mileage_end' => $this->faker->randomNumber(),
            'hours_start' => $this->faker->randomNumber(),
            'hours_end' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'vehicule_id' => Vehicule::factory(),
            'user_id' => User::factory(),
            'chantiers_id' => Chantiers::factory(),
        ];
    }
}
