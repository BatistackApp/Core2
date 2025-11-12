<?php

namespace Database\Factories\GPAO;

use App\Models\GPAO\ProductionLine;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionLineFactory extends Factory
{
    protected $model = ProductionLine::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
