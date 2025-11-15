<?php

namespace Database\Factories\Core;

use App\Models\Core\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseFactory extends Factory
{
    protected $model = Warehouse::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'code_postal' => $this->faker->postcode(),
            'ville' => $this->faker->word(),
            'pays' => $this->faker->word(),
            'is_default' => $this->faker->boolean(),
        ];
    }
}
