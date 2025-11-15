<?php

namespace Database\Factories\Vision;

use App\Models\Chantiers\Chantiers;
use App\Models\Vision\BimModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BimModelFactory extends Factory
{
    protected $model = BimModel::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'source_file_path' => $this->faker->word(),
            'source_file_type' => $this->faker->word(),
            'web_viewable_file_path' => $this->faker->word(),
            'processing_status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'chantiers_id' => Chantiers::factory(),
        ];
    }
}
