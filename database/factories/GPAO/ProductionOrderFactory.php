<?php

namespace Database\Factories\GPAO;

use App\Models\Articles\Articles;
use App\Models\Chantiers\Chantiers;
use App\Models\Commerces\Commande;
use App\Models\GPAO\ProductionOrder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductionOrderFactory extends Factory
{
    protected $model = ProductionOrder::class;

    public function definition(): array
    {
        return [
            'number' => $this->faker->word(),
            'quantity_to_produce' => $this->faker->randomFloat(),
            'quantity_produced' => $this->faker->randomFloat(),
            'due_date' => Carbon::now(),
            'started_at' => Carbon::now(),
            'completed_at' => Carbon::now(),
            'status' => $this->faker->word(),
            'estimated_coast' => $this->faker->randomFloat(),
            'actual_coast' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'articles_id' => Articles::factory(),
            'chantiers_id' => Chantiers::factory(),
            'commande_id' => Commande::factory(),
        ];
    }
}
