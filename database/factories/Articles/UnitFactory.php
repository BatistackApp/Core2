<?php

namespace Database\Factories\Articles;

use App\Models\Articles\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'symbol' => $this->faker->word(),
            'type' => $this->faker->word(),
        ];
    }
}
