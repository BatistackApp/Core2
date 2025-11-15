<?php

namespace Database\Factories\GRH;

use App\Models\GRH\LeaveEntitlement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LeaveEntitlementFactory extends Factory
{
    protected $model = LeaveEntitlement::class;

    public function definition(): array
    {
        return [
            'year' => $this->faker->word(),
            'type' => $this->faker->word(),
            'total_allocated' => $this->faker->randomFloat(),
            'total_taken' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
