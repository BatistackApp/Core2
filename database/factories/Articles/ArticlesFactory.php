<?php

namespace Database\Factories\Articles;

use App\Models\Articles\ArticleCategory;
use App\Models\Articles\Articles;
use App\Models\Articles\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ArticlesFactory extends Factory
{
    protected $model = Articles::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'reference' => $this->faker->word(),
            'barcode' => $this->faker->word(),
            'type_article' => $this->faker->word(),
            'is_stock_managed' => $this->faker->boolean(),
            'stock_alert_threshold' => $this->faker->randomFloat(),
            'price_achat_ht' => $this->faker->randomFloat(),
            'prix_vente_ht' => $this->faker->randomFloat(),
            'vat_rate' => $this->faker->randomFloat(),
            'is_active' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'unit_id' => Unit::factory(),
            'article_category_id' => ArticleCategory::factory(),
        ];
    }
}
