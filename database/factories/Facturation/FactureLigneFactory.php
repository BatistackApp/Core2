<?php

namespace Database\Factories\Facturation;

use App\Models\Facturation\Facture;
use App\Models\Facturation\FactureLigne;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FactureLigneFactory extends Factory
{
    protected $model = FactureLigne::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->text(),
            'vat_rate' => $this->faker->randomFloat(),
            'quantity' => $this->faker->randomFloat(),
            'unit' => $this->faker->word(),
            'unit_price_ht' => $this->faker->randomFloat(),
            'total_budget_amount' => $this->faker->randomFloat(),
            'previous_progress_percentage' => $this->faker->randomFloat(),
            'current_progress_percentage' => $this->faker->randomFloat(),
            'amount_ht' => $this->faker->randomFloat(),
            'amount_tva' => $this->faker->randomFloat(),
            'amount_tc' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'facture_id' => Facture::factory(),
        ];
    }
}
