<?php

namespace Database\Factories;

use App\Models\Tiers\Tiers;
use App\Models\Tiers\TiersLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TiersLogFactory extends Factory
{
    protected $model = TiersLog::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'event_day' => $this->faker->boolean(),
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now(),
            'status' => $this->faker->word(),
            'description' => $this->faker->text(),
            'lieu' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'tiers_id' => Tiers::factory(),
        ];
    }
}
