<?php

namespace Database\Factories\Chantiers;

use App\Models\Chantiers\Chantiers;
use App\Models\Chantiers\ChantiersIntervention;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ChantiersInterventionFactory extends Factory
{
    protected $model = ChantiersIntervention::class;

    public function definition(): array
    {
        return [
            'date_intervention' => Carbon::now(),
            'description' => $this->faker->text(),
            'temps' => $this->faker->randomFloat(2, 1, 2),
            'facturable' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'chantiers_id' => Chantiers::factory(),
            'intervenant_id' => User::factory(),
        ];
    }
}
