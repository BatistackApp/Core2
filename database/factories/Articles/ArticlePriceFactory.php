<?php

namespace Database\Factories\Articles;

use App\Models\Articles\ArticlePrice;
use App\Models\Articles\Articles;
use App\Models\Tiers\Tiers;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticlePriceFactory extends Factory
{
    protected $model = ArticlePrice::class;

    public function definition(): array
    {
        return [
            'price_level_name' => $this->faker->name(),
            'min_quantity' => $this->faker->randomFloat(),
            'price_ht' => $this->faker->randomFloat(),

            'articles_id' => Articles::factory(),
            'tiers_id' => Tiers::factory(),
        ];
    }
}
