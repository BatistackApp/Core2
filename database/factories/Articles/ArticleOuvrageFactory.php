<?php

namespace Database\Factories\Articles;

use App\Models\Articles\ArticleOuvrage;
use App\Models\Articles\Articles;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleOuvrageFactory extends Factory
{
    protected $model = ArticleOuvrage::class;

    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomFloat(),

            'parent_article_id' => Articles::factory(),
            'child_article_id' => Articles::factory(),
        ];
    }
}
