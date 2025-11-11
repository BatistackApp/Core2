<?php

namespace Database\Factories\Commerces;

use App\Models\Facturation\Facture;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FactureFactory extends Factory
{
    protected $model = Facture::class;

    public function definition(): array
    {
        return [
            'num_facture' => $this->faker->word(),
            'status' => $this->faker->word(),
            'type_facture' => $this->faker->word(),
            'date_facture' => Carbon::now(),
            'date_echue' => Carbon::now(),
            'situation_started_at' => Carbon::now(),
            'situation_ended_at' => Carbon::now(),
            'progress_percentage' => $this->faker->randomFloat(),
            'total_work_to_date' => $this->faker->randomFloat(),
            'previous_situations_total' => $this->faker->randomFloat(),
            'guarantee_retention_percentage' => $this->faker->randomFloat(),
            'guarantee_retention_amount' => $this->faker->randomFloat(),
            'guarantee_released' => $this->faker->boolean(),
            'amount_ht' => $this->faker->randomFloat(),
            'amount_tva' => $this->faker->randomFloat(),
            'amount_ttc' => $this->faker->randomFloat(),
            'notes' => $this->faker->word(),
            'pdf_path' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
