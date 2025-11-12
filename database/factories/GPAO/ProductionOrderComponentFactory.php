<?php

namespace Database\Factories\GPAO;

use App\Models\Articles\Articles;
use App\Models\GPAO\ProductionOrder;
use App\Models\GPAO\ProductionOrderComponent;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionOrderComponentFactory extends Factory
{
    protected $model = ProductionOrderComponent::class;

    public function definition(): array
    {
        return [
            'quantity_required' => $this->faker->randomFloat(),
            'quantity_consumed' => $this->faker->randomFloat(),
            'unit_cost' => $this->faker->word(),

            'production_order_id' => ProductionOrder::factory(),
            'articles_id' => Articles::factory(),
        ];
    }
}
