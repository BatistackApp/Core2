<?php

namespace Database\Factories\Vision;

use App\Models\Vision\BimModel;
use App\Models\Vision\BimObjectMetadata;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BimObjectMetadataFactory extends Factory
{
    protected $model = BimObjectMetadata::class;

    public function definition(): array
    {
        return [
            'object_guid' => $this->faker->uuid(),
            'object_type' => $this->faker->word(),
            'name' => $this->faker->name(),
            'properties' => $this->faker->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'bim_model_id' => BimModel::factory(),
        ];
    }
}
