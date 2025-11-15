<?php

namespace Database\Factories\Core;

use App\Models\Core\Bank;
use Illuminate\Database\Eloquent\Factories\Factory;

class BankFactory extends Factory
{
    protected $model = Bank::class;

    public function definition(): array
    {
        return [
            'bridge_id' => $this->faker->randomNumber(),
            'name' => $this->faker->name(),
            'logo_bank' => $this->faker->imageUrl(),
            'status_aggregation' => 'healthy',
            'status_payment' => 'healthy',
        ];
    }
}
