<?php

namespace Database\Factories\GPAO;

use App\Models\GPAO\ProductionLine;
use App\Models\GPAO\ProductionOrder;
use App\Models\GPAO\ProductionOrderOperation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductionOrderOperationFactory extends Factory
{
    protected $model = ProductionOrderOperation::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->text(),
            'time_spent_hours' => $this->faker->randomFloat(),
            'hourly_cost' => $this->faker->randomFloat(),
            'started_at' => Carbon::now(),
            'ended_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'production_order_id' => ProductionOrder::factory(),
            'user_id' => User::factory(),
            'production_line_id' => ProductionLine::factory(),
        ];
    }
}
