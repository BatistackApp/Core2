<?php

namespace Database\Factories\Facturation;

use App\Models\Facturation\Facture;
use App\Models\Facturation\FacturePayment;
use App\Models\Facturation\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FacturePaymentFactory extends Factory
{
    protected $model = FacturePayment::class;

    public function definition(): array
    {
        return [
            'amount_applied' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'facture_id' => Facture::factory(),
            'payment_id' => Payment::factory(),
        ];
    }
}
