<?php

namespace Database\Factories\Flottes;

use App\Models\Flottes\VehicleMaintenance;
use App\Models\Flottes\Vehicule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class VehicleMaintenanceFactory extends Factory
{
    protected $model = VehicleMaintenance::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->word(),
            'description' => $this->faker->text(),
            'schedule_at' => Carbon::now(),
            'completed_at' => Carbon::now(),
            'cost_amount' => $this->faker->randomFloat(),
            'provider_name' => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'vehicule_id' => Vehicule::factory(),
        ];
    }
}
