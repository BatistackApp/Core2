<?php

namespace Database\Factories\Facturation;

use App\Models\Core\ModeReglement;
use App\Models\Facturation\Payment;
use App\Models\Tiers\Tiers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(),
            'paid_at' => Carbon::now(),
            'reference' => $this->faker->word(),
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'tiers_id' => Tiers::factory(),
            'mode_reglement_id' => ModeReglement::factory(),
        ];
    }
}
