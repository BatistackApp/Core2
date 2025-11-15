<?php

namespace Database\Factories\Articles;

use App\Models\Articles\Articles;
use App\Models\Articles\ArticleStock;
use App\Models\Core\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleStockFactory extends Factory
{
    protected $model = ArticleStock::class;

    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomFloat(),
            'quantity_reserved' => $this->faker->randomFloat(),

            'articles_id' => Articles::factory(),
            'warehouse_id' => Warehouse::factory(),
        ];
    }
}
