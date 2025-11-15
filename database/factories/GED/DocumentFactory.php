<?php

namespace Database\Factories\GED;

use App\Models\GED\Document;
use App\Models\GED\DocumentCollection;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'status' => $this->faker->word(),
            'current_file_path' => $this->faker->word(),
            'current_filename' => $this->faker->word(),
            'current_mime_type' => $this->faker->word(),
            'current_size' => $this->faker->randomNumber(),
            'current_version_number' => $this->faker->randomNumber(),
            'is_signed' => $this->faker->boolean(),
            'signed_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'document_collection_id' => DocumentCollection::factory(),
        ];
    }
}
