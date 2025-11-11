<?php

namespace Database\Factories\Facturation;

use App\Models\Facturation\Facture;
use App\Models\Facturation\FactureReminder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FactureReminderFactory extends Factory
{
    protected $model = FactureReminder::class;

    public function definition(): array
    {
        return [
            'level' => $this->faker->randomNumber(),
            'status' => $this->faker->word(),
            'send_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'facture_id' => Facture::factory(),
        ];
    }
}
