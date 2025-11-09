<?php

namespace Database\Factories\Core;

use App\Models\Core\Option;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Core\Option>
 */
class OptionFactory extends Factory
{
    protected $model = Option::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'slug' => $this->faker->slug(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
