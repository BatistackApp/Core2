<?php

namespace Database\Factories\Articles;

use App\Models\Articles\Articles;
use App\Models\Articles\Inventory;
use App\Models\Articles\InventoryLine;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class InventoryLineFactory extends Factory
{
    protected $model = InventoryLine::class;

    public function definition(): array
    {
        return [
            'expected_quantity' => $this->faker->randomFloat(),
            'real_quantity' => $this->faker->randomFloat(),
            'location' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'inventory_id' => Inventory::factory(),
            'articles_id' => Articles::factory(),
        ];
    }
}
