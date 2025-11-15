<?php

namespace Database\Factories\GRH;

use App\Models\GRH\EmployeeQualification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EmployeeQualificationFactory extends Factory
{
    protected $model = EmployeeQualification::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'issued_by' => $this->faker->word(),
            'issued_at' => Carbon::now(),
            'expired_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
