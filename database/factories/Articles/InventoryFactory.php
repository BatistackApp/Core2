<?php

namespace Database\Factories\Articles;

use App\Models\Articles\Inventory;
use App\Models\Core\Warehouse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class InventoryFactory extends Factory
{
    protected $model = Inventory::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'inventory_date' => Carbon::now(),
            'status' => $this->faker->word(),
            'comment' => $this->faker->word(),
            'validated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'warehouse_id' => Warehouse::factory(),
            'user_id' => User::factory(),
        ];
    }
}
