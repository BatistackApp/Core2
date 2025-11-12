<?php

namespace Database\Factories\GED;

use App\Models\GED\Document;
use App\Models\GED\DocumentVersion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DocumentVersionFactory extends Factory
{
    protected $model = DocumentVersion::class;

    public function definition(): array
    {
        return [
            'version_number' => $this->faker->randomNumber(),
            'file_path' => $this->faker->word(),
            'filename' => $this->faker->word(),
            'mime_type' => $this->faker->word(),
            'size' => $this->faker->randomNumber(),
            'notes' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'document_id' => Document::factory(),
            'user_id' => User::factory(),
        ];
    }
}
