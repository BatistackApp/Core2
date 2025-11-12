<?php

namespace Database\Factories\GED;

use App\Models\GED\DocumentCollection;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentCollectionFactory extends Factory
{
    protected $model = DocumentCollection::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'is_public' => $this->faker->boolean(),
        ];
    }
}
